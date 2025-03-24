# Roles

---

- [Introducción](#introduction)
- [Archivos](#archivos)

<a name="introduction"></a>
## Introducción

En este módulo, se realiza la consulta, creación, edición y asignación de perimsos de los roles existentes en el sistema.

<a name="archivos"></a>
## Archivos

- <b>Repository:</b> RoleRepository.php
- <b>Service:</b> RoleService.php
- <b>Permisos:</b> RolePermission.php
- <b>Policy:</b> RolePolicy.php

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>role.index</td>
      <th>Permisos:</th>
      <td>ViewAny</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>RoleController@index</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - RolesTable.php
            <br>
            - CreateRole.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>role.show</td>
      <th>Permisos:</th>
      <td>View</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>RoleController@show</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - EditRole.php
            <br>
            - ManageRolePermissions.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>role.destroy</td>
      <th>Permisos:</th>
      <td>Delete</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>RoleController@destroy</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios empleados:</th>
        <td colspan="2">
            - RoleService.php
        </td>
    </tr>
  </tbody>
</table>
