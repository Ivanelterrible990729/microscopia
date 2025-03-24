# Registro de actividad

---

- [Introducción](#introduction)
- [Visualizar registros](#visualizar-registros)
- [Detalle de un registro](#detalle-registro)
- [Limpiar registro de actividades](#limpiar-registro)

<a name="introduccion"></a>
## Introducción

En este módulo, se recopilan las acciones realizadas por TODOS los usuarios del sistema. Es posible realizar las siguientes operaciones:

- Filtrar y buscar acciones.
- visualizar a detalle cualquier acción en particular.
- Eliminar todas las acciones a partir de cierta cantidad de días.

<a name="visualizar-registros"></a>
## Visualizar registros

Lo primero que usted verá al entrar al módulo será el listado de acciones. El listado muestra de la acción más actual a la más vieja y tiene las columnas:
- "ID"
- "Fecha y hora"
- "Causante"
- "Módulo"
- "Objeto"
- "Descripción"

Usted puede buscar registros por "Módulo" o por "Descripción", así como filtrar los registros por "Causante" o bien, por "Rango de fechas".

---

<a name="detalle-registros"></a>
## Detalle de un registro

Para visualizar el detalle de un registro, desde el listado, basta con hacer clic en el "ID" de la acción en cuestión.

- <i class="fa fa-info text-blue-500 mr-2"></i> Se abrirá un modal con el detalle de la acción.
- <i class="fa fa-info text-blue-500 mr-2"></i> Puede dirigirse al perfil del causante haciendo clic en el enlace que aparece en el campo "Causante".
- <i class="fa fa-info text-blue-500 mr-2"></i> Puede dirigirse al la entidad relacionada haciendo clic en el enlace que aparece en el campo "Objeto".

---

<a name="limpiar-registro"></a>
## Limpiar registro de actividades

Para limpiar el registro de actividades:

- Haga clic en el botón <span class="bg-danger text-white p-2 border rounded-lg">
                            <i class="fa fa-trash"></i>
                            Limpiar registro de actividades
                        </span>.
- Se abrirá un modal advertiendo las consecuencias de esta acción.
- Puede especificar el número de días a eliminar. el valor por default es 365.
- Puede especificar un módulo en específico para eliminar las acciones pertenecientes a dicho módulo. NO se eliminará ninguna acción si no se encuentra el módulo especificado.
- Para ejecutar la acción, haga clic en <span class="bg-danger text-white p-2 border rounded-lg">
                                            Limpiar
                                        </span>.

---
