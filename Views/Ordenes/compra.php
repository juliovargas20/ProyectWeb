<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Ordenes Internas /</span> Orden de Compra</h4>

    <hr>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th class="text-center" style="width: 150px;">Cantidad</th>
                        <th class="text-center">Unidades</th>
                        <th>Descripción</th>
                        <th class="text-center" style="width: 150px;">Precio U.</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">
                            <button type="button" class="btn btn-icon btn-label-danger waves-effect" onclick="">
                                <i class="mdi mdi-trash-can">
                                </i>
                            </button>
                        </td>
                        <td>
                            <input type="number" class="form-control">
                        </td>
                        <td>
                            <select class="form-control" name="" id="">
                                <option value="kg.">kg.</option>
                                <option value="eni.">uni.</option>
                            </select>
                        </td>
                        <td>
                            <textarea class="form-control" name="" id=""></textarea>
                        </td>
                        <td>
                            <input type="number" class="form-control">
                        </td>
                        <td>
                            <input type="text" class="form-control" readonly>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="p-1 text-right" colspan="5"><span><button class="btn btn btn-sm btn-flat btn-primary py-0 mx-1" type="button" id="add_row">Agregar Fila</button></span> Sub Total</th>
                        <th class="p-1 text-right" id="sub_total">0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>



<?php include "Views/templates/footer.php"; ?>