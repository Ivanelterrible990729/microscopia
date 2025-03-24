# Modelos CNN

---

- [Introducción](#introduccion)
- [Visualizar modelos](#visualizar-modelos)
- [Crear un modelo](#crear-modelo)
- [Editar un modelo](#editar-modelo)
- [Entrenar un modelo](#entrenar-modelo)
- [Eliminar un modelo](#eliminar-modelo)

<a name="introduccion"></a>
## Introducción

En este módulo, se registran y se entrenan los modelos CNN para llevar a cabo las predicciones y análisis de las imágenes que se suban al repositorio.
Entre las operaciones disponibles tenemos:

- Visualizar modelos.
- Crear un modelo.
- Editar un modelo.
- Entrenar un modelo.
- Eliminar un modelo.

---

<a name="visualizar-modelos"></a>
## Visualizar modelos

Lo primero que usted verá al entrar al módulo de Modelos CNN será un listado de los mismos. En este listado se muestran los modelos cargados en el sistema dedicados a las predicciones de las imágenes que se almacenen en el sistema.

En el listado se muestran las columnas:

- "Nombre"
- "Modelo cargado"
- "Etiquetas"
- "Creado el"
- "Actualizado el"

En este listado, es posible buscar el modelo por "Nombre" y es posible filtrar los modelos según las etiquetas a las que se especialicen.

> {info} Para visualizar el detalle de un modelo en específico, haga clic en el nombre del modelo.

---

<a name="crear-modelo"></a>
## Crear un modelo

Siga las instrucciones para crear un modelo CNN:

- Desde el listado de Modelos CNN. haga clic en el botón ubicado en la parte superior derecha
<span class="bg-green p-2 border rounded-lg text-white">
    <i class="fa fa-plus"></i>
    Crear Modelo CNN
</span>.
- Se abrirá un modal con los campos requeridos para registrar un Modelo CNN.
- Deberá completar el formulario.
- Haga clic en <span class="bg-success p-2 border rounded-lg">
                    Crear Modelo CNN
                </span>.

> {success} Una vez registrado el modelo, se le redireccionará al detalle del mismo.

---

<a name="editar-mmodelo"></a>
## Editar un Modelo CNN

<i class="fa fa-exclamation text-pending mr-2"></i> Para editar un Modelo CNN, primero debe acceder al detalle del mismo (haciendo clic en su nombre desde el listado de Modelos CNN).

- Dirijase a la sección titulada "Modelo CNN".
- Haga clic en <span class="bg-warning p-2 border rounded-lg">
                    <i class="fa fa-edit"></i>
                    Editar
                </span>.
- Complete los campos requeridos del formulario.
- Haga clic en <span class="bg-success p-2 border rounded-lg">
                    <i class="fa fa-save"></i>
                    Actualizar modelo CNN
                </span>.

> {success} Se mostrará un mensaje de confirmación una vez que el Modelo CNN esté actualizado.

---

<a name="entrenar-modelo"></a>
## Entrenar un Modelo CNN

<i class="fa fa-exclamation text-pending mr-2"></i> Para entrenar un Modelo CNN, primero debe acceder al detalle del mismo (haciendo clic en su nombre desde el listado de Modelos CNN).

- Dirijase a la sección titulada "Entrenar modelo".
- Complete los campos requeridos del formulario para entrenar el modelo.
 - Puede crear un modelo desde cero "Seleccionando el modelo imagenet" o re-entrenar uno existente.
- Haga clic en <span class="bg-green p-2 border rounded-lg">
                    Comenzar
                </span>.

> {success} Se mostrará un mensaje de confirmación una vez que el entrenamiento se haya realizado. Finalmente, haga clic en
<span class="bg-green p-2 border rounded-lg mx-2">
    Finalizar
</span> para poner fin al entrenamiento.


**Nota:** Este proceso puede tomar mucho tiempo. Se recomienda mantenerse activo en la página en todo momento.

---

<a name="eliminar-modelo"></a>
## Eliminar un modelo

<i class="fa fa-exclamation text-pending mr-2"></i> Para eliminar un modelo, primero debe acceder al detalle del mismo (haciendo clic en su nombre desde el listado de Modelos CNN).

- Dirijase en la sección titulada "Modelo CNN".
- Haga clic en <span class="bg-danger p-2 border rounded-lg text-white">
                    <i class="fa fa-trash"></i>
                    Eliminar
                </span>.
- Confirme la acción en la advertencia que aparece.

> {success} Será redirigido al listado de Modelos CNN una vez el modelo haya sido eliminado.

---
