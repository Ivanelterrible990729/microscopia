# Usuarios

---

- [Introducción](#introduccion)
- [Visualizar usuarios](#visualizar-usuarios)
- [Crear usuarios](#crear-usuarios)
- [Configurar usuarios](#configurar-usuarios)
- [Suplantar usuarios](#suplantar-usuarios)
- [Eliminar usuarios](#eliminar-usuarios)

<a name="introduccion"></a>
## Introducción

En este módulo, se realiza la gestión de usuarios en el sistema. Entre las operaciones disponibles tenemos:

- Visualizar usuarios.
- Crear usuarios.
- Configurar usuarios.
- Suplantar usuarios.
- Eliminar usuarios.

<a name="visualizar-usuarios"></a>
## Visualizar usuarios

Lo primero que usted verá al entrar al módulo de usuarios será un listado de los mismos. En este listado se encuentran las columnas "Foto", "Nombre", "Cargo", "Correo electrónico", y "Roles". En este listado, también es posible filtrar usuarios por su estatus o por sus roles.

> {info} Para visualizar el detalle de un usuario en específico, haga clic en el nombre del usuario.

---

<a name="crear-usuarios"></a>
## Crear usuarios

Para crear un usuario, desde el listado de usuarios, haga clic en el botón ubicado en la parte superior derecha
<span class="bg-green p-2 border rounded-lg text-white">
    <i class="fa fa-plus"></i>
    Crear usuario
</span>.

- Se abrirá un modal con los campos requeridos para registrar un usuario.
- Deberá completar el formulario para crear un usuario.
- Haga clic en <span class="bg-success p-2 border rounded-lg">
                    <i class="fa fa-save"></i>
                    Guardar
                </span>.

> {success} Una vez registrado el usuario, se le redireccionará al detalle del mismo.

---

<a name="configurar-usuarios"></a>
## Configurar usuarios

<i class="fa fa-exclamation text-pending mr-2"></i> Para configurar un usuario, primero debe acceder al detalle del mismo (haciendo clic en su nombre desde el listado de usuarios).

- Dirijase a la sección titulada "Configuración".
- Seleccione los roles que quiera asignar al usuario en cuestión.
- Para guardar la configuración, haga clic en   <span class="bg-success p-2 border rounded-lg">
                                                    <i class="fa fa-save"></i>
                                                    Guardar
                                                </span>.

> {success} Se mostrará un mensaje de confirmación una vez que que el usuario haya sido configurado.

---

<a name="suplantar-usuarios"></a>
## Suplantar usuarios

<i class="fa fa-exclamation text-pending mr-2"></i> Para suplantar un usuario, primero debe acceder al detalle del mismo (haciendo clic en su nombre desde el listado de usuarios).

- Dirijase a la sección titulada "Perfil".
- Haga clic en <span class="bg-warning p-2 border rounded-lg">
                    <i class="fa fa-user"></i>
                    Personificar
                </span>. 
- Será redireccionado a la página de inicio pero con la sesión del usuario. Esta funcionalidad facilita el soporte en la página.

> {info} Para salir de la suplantación, haga clic en el botón <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out mx-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg> ubicado en la barra superior de la página y posteriormente haga clic en
<span class="bg-danger p-2 border rounded-lg mx-2">
    <i class="fa fa-stop"></i>
    Detener personificación
</span> para cerrar la sesión del usuario suplantado.

---

<a name="eliminar-usuarios"></a>
## Eliminar usuarios


<i class="fa fa-exclamation text-pending mr-2"></i> Para eliminar un usuario, primero debe acceder al detalle del mismo (haciendo clic en su nombre desde el listado de usuarios).

- Dirijase en la sección titulada "Perfil".
- Haga clic en <span class="bg-danger p-2 border rounded-lg text-white">
                    <i class="fa fa-trash"></i>
                    Eliminar
                </span>.
- Confirme la acción en la advertencia que aparece.

> {success} Será redirigido al listado al usuario mismo una vez el usuario haya sido eliminado.

**Nota:**

Para restaurar al usuario eliminado, usted puede hacer clic en <span class="bg-danger p-2 border rounded-lg text-white">
                    <i class="fa fa-trash"></i>
                    Restaurar
                </span>.

---
