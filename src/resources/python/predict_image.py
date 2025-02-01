import argparse
import random

# Función para interpretar los argumentos recibidos.
def parse_args():
    parser = argparse.ArgumentParser()
    parser.add_argument('-mp', '--model_path', type=str, nargs='+', help='Path del modelo que realizará la predicción.')
    parser.add_argument('-ip', '--image_path', type=str, nargs='+', help='Path de la imagen que será predecida.')

    return vars(parser.parse_args())

def predict_image(args):

    results = ['MUSCULO', 'BACILOS', 'COCOS']
    label = random.choice(results)

    return label

# Función principal.
def main():
    args = parse_args()
    prediction = predict_image(args)

    print(prediction)

# Llmada a la función principal.
if __name__ == "__main__":
    main()
