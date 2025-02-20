import argparse
import os #To nagivate to the dataset files
import math # To truncate pixels
from PIL import Image # To crop images

def parse_args():
    """
    Función para interpretar los argumentos recibidos.
    """
    parser = argparse.ArgumentParser()
    parser.add_argument('-id', '--input_dir', type=str, nargs='+', help='Directorio del dataset al cual realizar el recorte.')
    parser.add_argument('-od', '--output_dir', type=str, nargs='+', help='Directorio donde se almacenará el dataset recortado.')
    parser.add_argument('-p', '--percentage', type=str, nargs='+', help='Porcentaje de altura a recortar.')

    return vars(parser.parse_args())


def crop_image(image, percentage):
    """
    Function to crop image to a specific size
    Params:
    - image: image to crop
    - percentage: percentage of cropping
    """
    width, height = image.size
    new_height = math.trunc((height * int(percentage)) / 100)
    crop_size = (width, new_height)

    if width < crop_size[0] or height < crop_size[1]:
        raise ValueError("Crop size is larger than the image dimensions.")

    box = (0, 0, crop_size[0], crop_size[1])  # (left, top, right, bottom)
    return image.crop(box)


def crop_images_from_directory(input_dir, output_dir, percentage):
    """
    Function to crop images within a directory.
    Args:
    - input_dir: image's directory
    - output_dir: location to save the new images
    - percentage: percentage of cropping
    """
    images_count = 0

    for root, dirs, files in os.walk(input_dir):
        for filename in files:
            if filename.endswith(".jpg") or filename.endswith(".png"):
                images_count += 1

                # Route to the original image
                img_path = os.path.join(root, filename)
                img = Image.open(img_path)

                # Crop the image by the size defined
                cropped_img = crop_image(img, percentage)

                # create new route corresponding to the output_dir
                relative_path = os.path.relpath(root, input_dir)
                output_subfolder = os.path.join(output_dir, relative_path)
                os.makedirs(output_subfolder, exist_ok=True)

                # save the cropped image
                cropped_img.save(os.path.join(output_subfolder, f"{filename.split('.')[0]}_cropped.jpg"))

    print(images_count)

def main():
    args = parse_args()

    crop_images_from_directory(
        input_dir = args['input_dir'][0],
        output_dir = args['output_dir'][0],
        percentage = args['percentage'][0]
    )

if __name__ == "__main__":
    main()
