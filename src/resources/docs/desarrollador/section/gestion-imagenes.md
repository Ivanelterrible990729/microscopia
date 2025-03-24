# Gestión de imágenes

---

- [Introducción](#introduction)
- [Archivos](#archivos)

<a name="introduction"></a>
## Introducción

En este módulo, se suben, se etiquetan, se editan, se predicen, se eliminan y se restauran las imágenes de este repositorio. Este es el módulo más extenso.

<a name="archivos"></a>
## Archivos

- <b>Repository:</b> ImageRepository.php
- <b>Service:</b> ImageService.php
- <b>Permisos:</b> ImagePermission.php
- <b>Policy:</b> ImagePolicy.php

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>image.pdf-report</td>
      <th>Permisos:</th>
      <td>Report</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>ImageController@pdfReport</td>
      <th>Request:</th>
      <td>ImageReportRequest.php</td>
    </tr>
    <tr>
        <th colspan="2">Servicios:</th>
        <td colspan="2">
            - ImageService.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>image.labeling</td>
      <th>Permisos:</th>
      <td>ManageLabels</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>ImageController@labeling</td>
      <th>Request:</th>
      <td>ImageLabelingRequest.php</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - ImagesWizard.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>image.donwload</td>
      <th>Permisos:</th>
      <td>Ninguno</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>ImageController@downloadImage</td>
      <th>Request:</th>
      <td>Ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Servicios:</th>
        <td colspan="2">
            - ImageService.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>image.index</td>
      <th>Permisos:</th>
      <td>ViewAny</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>ImageController@index</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - ImagesTable.php
            <br>
            - UploadImages.php
            <br>
            - ManageImageReport.php
            <br>
            - ManageImageDeletion.php
            <br>
            - CreateLabel.php
            <br>
            - EditLabel.php
            <br>
            - DeleteLabel.php
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>image.show</td>
      <th>Permisos:</th>
      <td>View</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>ImageController@show</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - PredictImage.php
            <br>
            - ManageLabelsImage.php
            <br>
            - ManageImageReport.php
            <br>
            - ManageImageDeletion.php x2 (Para Eliminar y restaurar)
        </td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <th>Ruta:</th>
      <td>image.edit</td>
      <th>Permisos:</th>
      <td>Update</td>
    </tr>
    <tr>
      <th>Controlador:</th>
      <td>ImageController@edit</td>
      <th>Request:</th>
      <td>ninguno</td>
    </tr>
    <tr>
        <th colspan="2">Componentes de livewire:</th>
        <td colspan="2">
            - EditImage.php
        </td>
    </tr>
  </tbody>
</table>
