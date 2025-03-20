# Desarrollador

---

- [Introducción](#introduction)
- [Módulos](#modulos)

<a name="introduction"></a>
## Introducción

En la presente sección, se dará una breve introducción sobre el estándar establecido para realizar/mantener un desarrollo sólido y escalable de la aplicación.

<br>

Todo módulo desarrollado de la aplicación debe mantener las siguiente estructura para evitar la interdependencia de código en el sistema:

<br>

<div class="w-full border-2">
    1. Base de datos
</div>
<ul class="list-disc pl-6 border-r-2 border-l-2 border-b-2">
    <li>
        <b>Repository:</b> Una clase para gestionar procesos de creación(almacenamiento), edición(actualización) o eliminación de registros en la base de datos.
    </li>
</ul>

<br>

<div class="w-full border-2">
    2. Lógica de negocio (algoritmos, consultas a API, etc.)
</div>
<ul class="list-disc pl-6 border-r-2 border-l-2 border-b-2">
    <li>
        <b>Service:</b> Una clase encargada de realizar la lógica/tareas robusta. De esta forma se mantiene segmentada la estructura del sistema con la lógica de negocio.
    </li>
</ul>

<br>

<div class="w-full border-2">
    3. Estructura del sistema (clases del Framework de Laravel)
</div>
<ul class="list-disc pl-6 border-r-2 border-l-2 border-b-2">
    <li>
        <b>Controladores:</b> Clases encargadas de gestionar propiedades y valores que ayuden a la navegación y recolección de datos del sistema.
    </li>
    <li>
        <b>Componentes de livewire:</b> Aquí NO se realiza ninguna lógica de negocio, únicamente se utilizan estas clases para conectar elementos de la estructura del sistema (Policies & Request) a la lógica de negocio (Services y Repositories).
    </li>
</ul>

<br>

<div class="w-full border-2">
    4. Vistas
</div>
<ul class="list-disc pl-6 border-r-2 border-l-2 border-b-2">
    <li>
        <b>Blade:</b> Aquí únicamente se muestra la información relevante al usuario. En este nivel no se realizan procesos que comprometan la seguridad del sistema.
    </li>
</ul>

<a name="modulos"></a>
## Módulos

A continuación, se enlistan los módulos desarrollados en el sistema. En cada módulo se enlistarán los archivos utilizados:

<br>

<il class="space-y-2">
    <li>
        <a href="section/inicio" class="text-blue-500">
            Inicio
        </a>
    </li>
    <li>
        <a href="section/roles" class="text-blue-500">
            Roles
        </a>
    </li>
    <li>
        <a href="section/usuarios" class="text-blue-500">
            Usuarios
        </a>
    </li>
    <li>
        <a href="section/registro-actividad" class="text-blue-500">
            Registro de actividad
        </a>
    </li>
    <li>
        <a href="section/modelos-cnn" class="text-blue-500">
            Modelos CNN
        </a>
    </li>
    <li>
        <a href="section/gestion-imagenes" class="text-blue-500">
            Gestión de imágenes
        </a>
    </li>
</il>
