import argparse
import os # to access to the dataset
import numpy as np # to redimension images
from tensorflow.keras.preprocessing.image import load_img, img_to_array, ImageDataGenerator # to load & augment images

def parse_args():
    """
    Función para interpretar los argumentos recibidos.
    """
    parser = argparse.ArgumentParser()
    parser.add_argument('-id', '--input_dir', type=str, nargs='+', help='Directorio del dataset al cual realizar el recorte.')
    parser.add_argument('-od', '--output_dir', type=str, nargs='+', help='Directorio donde se almacenará el dataset recortado.')

    return vars(parser.parse_args())

def data_augmentation_from_directory(input_dir, output_dir, datagen, images_per_class, save_format, img_size):
    """
    La funcion realiza data_augmentation de manera recursiva por cada uno de los directorios indicados.
    """
    images_count = 0

    for root, dirs, files in os.walk(input_dir):
        # Only process folders with image files
        if not files:
            continue

        # Calculate relative path to maintain directory structure in output_dir
        relative_path = os.path.relpath(root, input_dir)
        output_subfolder = os.path.join(output_dir, relative_path)
        os.makedirs(output_subfolder, exist_ok=True)

        for filename in files:
            if filename.endswith(".jpg") or filename.endswith(".png"):
                img_path = os.path.join(root, filename)

                # Load the image and prepare it for augmentation
                img = load_img(img_path, target_size=img_size)
                img_array = img_to_array(img)
                img_array = np.expand_dims(img_array, 0)  # Shape (1, h, w, c)

                # Generate augmented images
                i = 0
                for batch in datagen.flow(
                    img_array,
                    batch_size=1,
                    save_to_dir=output_subfolder,
                    save_prefix="aug",
                    save_format=save_format
                ):
                    i += 1
                    if i >= images_per_class:
                        break

                images_count += len([name for name in os.listdir(output_subfolder) if os.path.isfile(os.path.join(output_subfolder, name))])

    print(images_count)

def main():
    args = parse_args()

    parameters = { # Input, output and percentage of cropping
        'input_dir': args['input_dir'][0],
        'output_dir': args['output_dir'][0],
        'images_per_class': 150, # 150 per image
        'img_size': (224, 224),
        'save_format': 'jpg',
        'datagen': ImageDataGenerator(
            zoom_range=[0.4, 0.7],         # Zoom aleatorio del 30% (0.7) al 60% (0.4)
            horizontal_flip=True,          # Volteo horizontal
            vertical_flip=True,            # Volteo horizonta
            rotation_range=60,             # Rotación aleatoria en grados (90%)
            fill_mode='nearest'            # Asegura que el borde de la imagen no tenga relleno extraño
        ),
    }

    data_augmentation_from_directory(
        input_dir=parameters['input_dir'],
        output_dir=parameters['output_dir'],
        datagen=parameters['datagen'],
        images_per_class=parameters['images_per_class'],
        save_format=parameters['save_format'],
        img_size=parameters['img_size'],
    )

if __name__ == "__main__":
    main()
