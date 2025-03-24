# Gestión de imágenes

---

- [Introducción](#introduccion)
- [Visualizar imágenes](#visualizar-imagenes)
- [Subir imágenes](#subir-imagenes)
- [Analizar imágenes](#analizar-imagenes)
- [Generar informe de análisis](#generar-informe)
- [Clasificar y editar imágenes](#clasificar-editar-imagenes)
- [Eliminar imágenes](#eliminar-imagenes)

<a name="introduccion"></a>
## Introducción

Éste es el módulo principal del sistema. en él es posible:
- Subir imágenes.
- Analizar imágenes.
- Generar un informe de análisis.
- Clasificar y editar imágenes.
- Eliminar imágenes.

<a name="visualizar-imagenes"></a>
## Visualizar imágenes

Lo primero que usted verá al entrar al módulo de Gestión de imágenes sera el listado de las mismas. Por cada imagen, se muestra su ilustración, su nombre, su autor y su etiqueta(s).

- Es posible filtrar por imágenes activas o eliminadas.
- Es posible filtrar imágenes por etiqueta / multiples etiquetas.
- En el filtrado de etiquetas, es posible crear, editar o eliminar cualquier etiqueta.
- Es posible seleccionar múltiples imágenes para realizar multiples "Acciones globales"; Etiquetado de imágenes, informe de análisis y eliminación de imágenes.

---

<a name="subir-imagenes"></a>
## Subir imágenes

Para crear un rol, desde el listado de imágenes, haga clic en el botón ubicado en la parte superior derecha
<span class="bg-green p-2 border rounded-lg text-white">
    <i class="fa fa-plus"></i>
    Subir imágenes
</span>.

- Se abrirá un modal que pedirá las imágenes a subir.
- Deberá subir un máximo de 10 imágenes.
- Haga clic en <span class="bg-success p-2 border rounded-lg mx-2">
                    <i class="fa fa-upload"></i>
                    Subir imágenes
                </span> para cargar las imágenes.

> {success} Una vez almacenadas las imágenes, el sistema le redireccionará a una vista para **Clasificar y editar imágenes**. Para mayor información, diríjase a dicha sección.

---

<a name="analizar-imagenes"></a>
## Analizar imágenes

Para analizar una imagen en particular:

- Desde el listado de imágenes, haga clic en la ilustración de una imagen para acceder al detalle de la misma.
- Diríjase a la sección **Modelos CNN** y seleccione el modelo a utilzar para llevar a cabo el análisis.
- Haga clic en el botón de  <span class="bg-slate-200 p-2 border rounded-lg mx-2">
                                <i class="fa fa-eye"></i>
                                Analizar
                            </span> para analizar la imagen.
> {success} El sistema arrojará una predicción para la imagen seleccionada junto a su porcentaje de coincidencia.

---

<a name="generar-informe"></a>
## Generar informe de análisis

Para generar el informe de análisis de una imagen en particular:

- Desde el listado de imágenes, haga clic en la ilustración de una imagen para acceder al detalle de la misma.
- Diríjase a la parte superior derecha y haga clic en el botón de
    <span class="bg-black text-white p-2 border rounded-lg mx-2">
    <i class="fa fa-file"></i>
    Informe de análisis
    </span> para generar el informe.
> {success} El sistema retornará un archivo PDF con el informe generado.

**Nota:** Esta acción también se puede realizar desde el listado de imágenes seleccionando múltiples elementos.

---

<a name="clasificar-editar-imagenes"></a>
## Clasificar y editar imágenes.

- Se llega a esta funcionalidad cuando se suben nuevas imágenes, o bien, desde el listado de imágenes, seleccionando múltiples elementos y haciendo clic en
<span class="bg-slate-200 p-2 border rounded-lg">
    <i class="fa fa-tag"></i>
    Etiquetado de imágenes
</span>. Puedes editar la información de las imágenes e incluso etiquetar cada imagen con esta funcionalidad.

- Usted puede editar una imágen haciendo clic el botón
<span class="bg-warning p-2 border rounded-lg">
    <i class="fa fa-edit"></i>
    Editar
</span>, desde el detalle de una imágen en particular.

---

<a name="eliminar-imagenes"></a>
## Eliminar imágenes

<i class="fa fa-exclamation text-pending mr-2"></i> Para eliminar una imagen, primero debe acceder al detalle de la misma (haciendo clic en su ilustración desde el listado de imágenes).

- Haga clic en <span class="bg-danger p-2 border rounded-lg text-white">
                    <i class="fa fa-trash"></i>
                    Eliminar
                </span>.
- Confirme la acción en la advertencia que aparece.

> {success} Se le mostrará un mensaje de éxito al finalizar la eliminación de la imagen.


**Nota:** También es posible eliminar múltiples imágenes desde el listado de imágenes, seleccionando múltiples elementos.

---
