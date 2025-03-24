# Modelos CNN

---

- [Introducción](#introduction)
- [Archivos](#archivos)

<a name="introduction"></a>
## Introducción

En este módulo, se crean, editan, entrenan y eliminan los modelos CNN que serán encargados de clasificar
las imágenes del repositorio a partir de las etiquetas definidas dentro de este. En este método también se ejecutan scripts de python para llevar a cabo los entrenamientos de los modelos CNN.

<a name="archivos"></a>
## Archivos

- <b>Repository:</b> CnnModelRepository.php
- <b>Service:</b> CnnModelService.php
- <b>Permisos:</b> CnnModelPermission.php
- <b>Policy:</b> CnnModelPolicy.php

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>cnn-model.index</td>
      <th>Permisos:</th>
      <td>ViewAny</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>CnnModelController@index</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - CnnModelsTable.php
            <br>
            - CreateCnnModel.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>cnn-model.show</td>
      <th>Permisos:</th>
      <td>View</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>CnnModelController@show</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - EditCnnModel.php
            <br>
            - InfoCnnModel.php
            <br>
            - TrainCnnModel.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>cnn-model.destroy</td>
      <th>Permisos:</th>
      <td>Delete</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>CnnModelController@destroy</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios:</th>
        <td colspan="2">
            - CnnModelService.php
        </td>
    </tr>
  </tbody>
</table>
