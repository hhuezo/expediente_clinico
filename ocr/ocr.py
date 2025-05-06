import easyocr
import re
from PIL import Image
import sys
import json
import logging

# Configurar el logger
logging.basicConfig(filename='ocr_script.log', level=logging.DEBUG, format='%(asctime)s - %(levelname)s - %(message)s')

# Obtener la ruta de la imagen desde los argumentos de la línea de comandos
imagen_path = sys.argv[1]  # El primer argumento es la ruta de la imagen

# Asegurarse de que la ruta recibida es la correcta
logging.debug(f"Ruta de la imagen: {imagen_path}")  # Esto te ayudará a depurar la ruta

# Crear lector para idioma español e inglés
reader = easyocr.Reader(['es', 'en'])

# Intentar abrir la imagen con PIL
try:
    logging.info(f"Intentando abrir la imagen en: {imagen_path}")
    imagen = Image.open(imagen_path)

    # Reducir tamaño (ajustar factor de escala)
    imagen_resized = imagen.resize((imagen.width // 2, imagen.height // 2))


    # Guardar la imagen reducida temporalmente
    imagen_resized.save('dui_resized.jpg')
    logging.info(f"Imagen redimensionada y guardada como 'dui_resized.jpg'.")

    # Leer texto de la imagen reducida
    resultado = reader.readtext('dui_resized.jpg')

    # Concatenar el texto extraído
    texto = ' '.join([texto for _, texto, _ in resultado])

    logging.debug(f"Texto extraído completo: {texto}")

    # Función para extraer los campos necesarios usando expresiones regulares
    def extraer_datos(texto):
        # Expresión regular para extraer el número de DUI (formato 99999999-9)
        dui = re.search(r'\b\d{8}-\d{1}\b', texto)

        # Expresión regular para extraer el nombre completo
        nombre = re.search(r'Nombre\s*/\s*Given\s*Names\s*(.*?)(?=\s*Conocido)', texto)

        # Expresión regular para extraer los apellidos, excluyendo "Surname"
        apellidos = re.search(r'Apellidos\s*(.*?)(?=\s*Nombre)', texto)
        if apellidos:
            apellidos = apellidos.group(1).replace('Surname', '').strip()  # Eliminar "Surname"

        # Extraer y devolver los datos encontrados
        return {
            'documento': dui.group(0) if dui else None,
            'nombre': nombre.group(1).strip() if nombre else None,
            'apellido': apellidos if apellidos else None
        }

    # Extraer los datos
    datos_extraidos = extraer_datos(texto)

    logging.info(f"Datos extraídos: {datos_extraidos}")

    # Imprimir los datos extraídos
    for campo, valor in datos_extraidos.items():
        logging.debug(f"{campo.capitalize()}: {valor}")

    # Devolver los datos como un JSON
    print(json.dumps(datos_extraidos))

except FileNotFoundError as e:
    logging.error(f"Error: No se pudo encontrar el archivo: {imagen_path}")
    print(f"Error: No se pudo encontrar el archivo: {imagen_path}")

except Exception as e:
    logging.error(f"Error inesperado: {str(e)}")
    print(f"Error inesperado: {str(e)}")
