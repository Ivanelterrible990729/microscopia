import argparse
import numpy as np
import tensorflow as tf
from tensorflow.keras.preprocessing import image

def parse_args():
    """
    Función para interpretar los argumentos recibidos.
    """
    parser = argparse.ArgumentParser()
    parser.add_argument('-mp', '--model_path', type=str, help='Path del modelo que realizará la predicción.')
    parser.add_argument('-ip', '--image_paths', type=str, nargs='+', help='Paths de las imágenes a predecir.')
    parser.add_argument('-cl', '--class_labels', type=str, help='Etiquetas a utilizar en la predicción')

    return vars(parser.parse_args())

def load_model(model_path):
    """
    Carga el modelo desde la ruta especificada.
    """
    return tf.keras.models.load_model(model_path)

def preprocess_image(img_path, target_size=(224, 224)):
    """
    Carga y preprocesa una imagen para la predicción con MobileNetV2.
    """
    img = image.load_img(img_path, target_size=target_size)
    img_array = image.img_to_array(img)
    img_array = np.expand_dims(img_array, axis=0)  # Agregar dimensión batch
    img_array /= 255.0  # Normalización si se usó en el entrenamiento

    return img_array

def predict_image(model, img_path, class_labels):
    """
    Realiza la predicción de una imagen y retorna la clase y la probabilidad.
    """
    img_array = preprocess_image(img_path)
    predictions = model.predict(img_array)  # Salida con softmax
    predicted_index = np.argmax(predictions)  # Índice de la clase con mayor probabilidad
    predicted_class = class_labels[predicted_index]
    confidence = predictions[0][predicted_index] * 100  # Convertir a porcentaje

    return predicted_class, confidence

def main():
    args = parse_args()
    model_path = args['model_path']
    image_paths = args['image_paths']
    class_labels = args['class_labels'].strip("[]").split(",")

    model = load_model(model_path)

    for image_path in image_paths:
        predicted_class, confidence = predict_image(model, image_path, class_labels)
        print(f"{predicted_class} | {confidence:.2f}")

if __name__ == "__main__":
    main()
