# Registro de actividad

---

- [Introducción](#introduction)
- [Archivos](#archivos)

<a name="introduction"></a>
## Introducción

En este módulo, se está registrando toda acción que realice cualquier usuario en el sistema. únicamente
se registran las acciones de escritura y de actualización, o bien, acciones que demanden mucho recurso en el sistema.

<a name="archivos"></a>
## Archivos

- <b>Repository:</b> Ninguno
- <b>Service:</b> ActivitylogService.php extends ActivityInterface.
- <b>Permisos:</b> ActivitylogPermission.php
- <b>Policy:</b> ActivityPolicy.php

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>activitylog.index</td>
      <th>Permisos:</th>
      <td>ViewAny</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>ActivitylogController@index</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - ActivitiesTable.php
            <br>
            - ClearActivities.php
        </td>
    </tr>
  </tbody>
</table>
