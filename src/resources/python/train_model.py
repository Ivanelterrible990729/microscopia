import argparse

# tensorflow & keras
import tensorflow as tf
from tensorflow.keras import layers, models

# Model implementation, traning and testing
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.optimizers import SGD
from tensorflow.keras.regularizers import l2
from tensorflow.keras.callbacks import EarlyStopping, ModelCheckpoint

# Save Model
import os

def parse_args():
    """
    Función para interpretar los argumentos recibidos.
    """
    parser = argparse.ArgumentParser()
    parser.add_argument('-cn', '--class_names', type=str, nargs='+', help='Clases a utilizar para el entrenamiento y la ubicación de directorios')
    parser.add_argument('-mc', '--model_directory', type=str, nargs='+', help='Path del modelo a utilizar en el entrenamiento.')
    parser.add_argument('-dd', '--data_directory', type=str, nargs='+', help='Path del dataset a utilizar en el entrenamiento.')
    parser.add_argument('-vp', '--validation_portion', type=str, nargs='+', help='Porción del dataset a utilizar en el conjunto de validación.')
    parser.add_argument('-bm', '--is_base_model', type=str, nargs='+', help='Indica si el modelo ya estuvo armado o hay que armarlo.')
    parser.add_argument('-od', '--output_dir', type=str, nargs='+', help='Directorio en donde se guardará el modelo.')

    return vars(parser.parse_args())

def loadDataset(data_directory, class_names, img_size, batch_size, validation_portion):
    """
    Carga de dataset, training and validation.
    """
    train_datagen = ImageDataGenerator(
        rescale=1./255,  # Normalización de píxeles
        validation_split= float(validation_portion)  # validation_portion (0.2) para validación
    )

    # Generador de imágenes para entrenamiento (80%)
    train_generator = train_datagen.flow_from_directory(
        directory=data_directory,
        classes=class_names,
        target_size=img_size,
        batch_size=batch_size,
        class_mode='binary',  # Usa 'categorical' si tienes más de 2 clases
        shuffle=True,
        subset="training"  # Solo usa imágenes para entrenamiento
    )

    # Generador de imágenes para validación (20%)
    val_generator = train_datagen.flow_from_directory(
        directory=data_directory,
        classes=class_names,
        target_size=img_size,
        batch_size=batch_size,
        class_mode='binary',  # Usa 'categorical' si tienes más de 2 clases
        shuffle=False,  # No es necesario mezclar en validación
        subset="validation"  # Solo usa imágenes para validación
    )

    return [train_generator, val_generator]

def buildModel(model_directory, num_classes, is_base_model):
    """
    Si el modelo es base:
        - Se arma la arquitectura faltante para hacer tunning.
    De otra manera:
        - Se reemplaza la capa de salida.
    """
    base_model = models.load_model(model_directory)

    if is_base_model:
        base_model.trainable = False
        x = base_model.output
        x = layers.GlobalAveragePooling2D()(x)
        x = layers.Dense(128, activation='relu')(x)
        x = layers.Dropout(0.5)(x)
        predictions = layers.Dense(num_classes, activation='softmax', kernel_regularizer=l2(0.01))(x)
    else:
        x = base_model.layers[-2].output
        predictions = layers.Dense(num_classes, activation='softmax', kernel_regularizer=l2(0.01), name='new_output')(x)

    model = models.Model(inputs = base_model.input, outputs = predictions)
    return model

def main():
    args = parse_args()

    class_names = args['class_names'][0]
    class_names = class_names.strip("[]").split(",")
    model_directory = args['model_directory'][0]
    data_directory = args['data_directory'][0]
    validation_portion = args['validation_portion'][0]
    is_base_model = args['is_base_model'][0] == "1"
    output_dir = args['output_dir'][0]

    # --------------------------------------------------------------------------
    # Model params -------------------------------------------------------------
    # --------------------------------------------------------------------------

    num_classes = len(class_names)
    loss = "sparse_categorical_crossentropy" # "categorical_crossentropy"
    metrics = ["accuracy"]
    #optimizer = "adam"
    optimizer = SGD(
        learning_rate=1e-3,
        momentum=0.9,
    )

    # --------------------------------------------------------------------------
    # Training params ----------------------------------------------------------
    # --------------------------------------------------------------------------

    epochs = 100
    batch_size = 64
    img_size = (224, 224)

    # --------------------------------------------------------------------------
    # Load daset ---------------------------------------------------------------
    # --------------------------------------------------------------------------

    [train_generator, val_generator] = loadDataset(
        data_directory = data_directory,
        class_names = class_names,
        img_size = img_size,
        batch_size = batch_size,
        validation_portion = validation_portion
    )

    # --------------------------------------------------------------------------
    # Load model ---------------------------------------------------------------
    # --------------------------------------------------------------------------

    model = buildModel(
        model_directory=model_directory,
        num_classes=num_classes,
        is_base_model=is_base_model
    )

    model.compile(optimizer=optimizer, loss=loss, metrics=metrics)

    # --------------------------------------------------------------------------
    # Callbacks ----------------------------------------------------------------
    # --------------------------------------------------------------------------

    os.makedirs(output_dir, exist_ok=True)

    checkpoint = ModelCheckpoint(
        filepath=f"{output_dir}/{os.path.basename(model_directory)}",
        monitor='val_accuracy',   # Metric to monitor for improvement
        save_best_only=True,      # Save only the best model
    )

    early_stopping = EarlyStopping(
        monitor='val_accuracy',     # Metric to monitor
        patience=5,                 # Number of epochs to wait before stopping if no improvement
        restore_best_weights=True,  # Restores model weights from the epoch with the best value
    )

    callbacks=[checkpoint, early_stopping]

    # --------------------------------------------------------------------------
    # Train model --------------------------------------------------------------
    # --------------------------------------------------------------------------

    model_history = model.fit(
        train_generator,
        validation_data=val_generator,
        epochs=epochs,
        batch_size=batch_size,
        callbacks=callbacks
    )

    # --------------------------------------------------------------------------
    # Return model & metrics ---------------------------------------------------
    # --------------------------------------------------------------------------

    print(f"{output_dir}/{os.path.basename(model_directory)}")
    print(f"{model_history.history['accuracy'][-1]:.4f}")
    print(f"{model_history.history['loss'][-1]:.4f}")
    print(f"{model_history.history['val_accuracy'][-1]:.4f}")
    print(f"{model_history.history['val_loss'][-1]:.4f}")

if __name__ == "__main__":
    main()
