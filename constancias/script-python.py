import sys
import json
from docx import Document


def crear_doc(datos):
    tipo_constancia = datos['tipo_constancia']
    empleado = datos['empleado']
    director = datos['director']

    # Cargar la plantilla correspondiente al tipo de constancia
    documento = Document(f'Constancias-Tipo-{tipo_constancia}.docx')

    # Reemplazar marcadores en el documento para cada tipo de constancia
    for p in documento.paragraphs:
        if '{TITULO_EMPLEADO}' in p.text:
            p.text = p.text.replace('{TITULO_EMPLEADO}', empleado['titulo'])
        if '{NOMBRES_EMPLEADO}' in p.text:
            p.text = p.text.replace('{NOMBRES_EMPLEADO}', empleado['nombres'])
        if '{APELLIDO_P_EMPLEADO}' in p.text:
            p.text = p.text.replace('{APELLIDO_P_EMPLEADO}', empleado['apellido_p'])
        if '{APELLIDO_M_EMPLEADO}' in p.text:
            p.text = p.text.replace('{APELLIDO_M_EMPLEADO}', empleado['apellido_m'])
        if '{TURNO_EMPLEADO}' in p.text and tipo_constancia in ['3', '4', '5']:
            p.text = p.text.replace('{TURNO_EMPLEADO}', empleado['turno'])
        if '{HORARIO_ENTRADA}' in p.text and tipo_constancia in ['4', '5']:
            p.text = p.text.replace('{HORARIO_ENTRADA}', empleado['horario_entrada'])
        if '{HORARIO_SALIDA}' in p.text and tipo_constancia in ['4', '5']:
            p.text = p.text.replace('{HORARIO_SALIDA}', empleado['horario_salida'])
        if '{PUESTO_EMPLEADO}' in p.text and tipo_constancia in ['4', '5']:
            p.text = p.text.replace('{PUESTO_EMPLEADO}', empleado['puesto'])
        if '{ID_EMPLEADO}' in p.text and tipo_constancia in ['4', '5']:
            p.text = p.text.replace('{ID_EMPLEADO}', str(empleado['id_empleado']))
        if '{RFC_EMPLEADO}' in p.text and tipo_constancia in ['4', '5']:
            p.text = p.text.replace('{RFC_EMPLEADO}', empleado['RFC'])
        if '{FECHA_CONTRATO}' in p.text and tipo_constancia in ['4', '5']:
            p.text = p.text.replace('{FECHA_CONTRATO}', empleado['fecha_contrato'])
        if '{CALLE}' in p.text and tipo_constancia == '5':
            p.text = p.text.replace('{CALLE}', empleado['calle'])
        if '{NUMERO}' in p.text and tipo_constancia == '5':
            p.text = p.text.replace('{NUMERO}', empleado['numero'])
        if '{COL_FRACC}' in p.text and tipo_constancia == '5':
            p.text = p.text.replace('{COL_FRACC}', empleado['col_fracc'])
        if '{TELEFONO_MOVIL}' in p.text and tipo_constancia == '5':
            p.text = p.text.replace('{TELEFONO_MOVIL}', empleado['telefono_movil'])
        if '{EMAIL}' in p.text and tipo_constancia == '5':
            p.text = p.text.replace('{EMAIL}', empleado['email'])

        p.text = p.text.replace('{TITULO_DIRECTOR}', director['titulo'])
        p.text = p.text.replace('{NOMBRES_DIRECTOR}', director['nombres'])
        p.text = p.text.replace('{APELLIDO_P_DIRECTOR}', director['apellido_p'])
        p.text = p.text.replace('{APELLIDO_M_DIRECTOR}', director['apellido_m'])

    # Guardar el documento generado por el script
    documento.save('constancia_generada.docx')

# Obtener los datos
datos = json.loads(sys.argv[1])

# Generar el documento
crear_doc(datos)
