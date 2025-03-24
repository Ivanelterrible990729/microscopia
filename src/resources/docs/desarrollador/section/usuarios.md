# Usuarios

---

- [Introducción](#introduction)
- [Archivos](#archivos)

<a name="introduction"></a>
## Introducción

En este módulo, se gestionan los usuarios registrados en el sistema, además de gestionar sus roles y poder realizar otras acciones como inactivarlos o suplantarlos.

<a name="archivos"></a>
## Archivos

- <b>Repository:</b> UserRepository.php
- <b>Service:</b> Userservice.php
- <b>Permisos:</b> UserPermission.php
- <b>Policy:</b> UserPolicy.php

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>user.index</td>
      <th>Permisos:</th>
      <td>ViewAny</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>UserController@index</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - UsersTable.php
            <br>
            - CreateUser.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>user.show</td>
      <th>Permisos:</th>
      <td>View</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>UserController@show</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - ConfigureUser.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>user.destroy</td>
      <th>Permisos:</th>
      <td>Delete</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>UserController@destroy</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios empleados:</th>
        <td colspan="2">
            - UserService.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>user.restore</td>
      <th>Permisos:</th>
      <td>Restore</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>UserController@restore</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios empleados:</th>
        <td colspan="2">
            - UserService.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>user.profile-photo.download</td>
      <th>Permisos:</th>
      <td>Ninguno</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>UserController@downloadProfilePhoto</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios empleados:</th>
        <td colspan="2">
            - UserService.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>user.personification.start</td>
      <th>Permisos:</th>
      <td>Personify</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>UserController@startPersonification</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios empleados:</th>
        <td colspan="2">
            - UserService.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>user.personification.start</td>
      <th>Permisos:</th>
      <td>Personify</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>UserController@stopPersonification</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios empleados:</th>
        <td colspan="2">
            - UserService.php
        </td>
    </tr>
  </tbody>
</table>
