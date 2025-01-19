@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Purchase Order</h4>
                        <br>
                        <form method="post" action="{{ route('purchaseOrder.store') }}" id="myForm" enctype="multipart/form-data">
                            <div id="structure-form-purchase-order-c">
                                @csrf
                                <div class="div-purchase-order-c">
                                    <!-- Purchase Order Number -->
                                    <div class="">
                                        <label for="P.O Number" class="">P.O Nº</label>
                                        <div class="">
                                            <input name="pONumber" class="form-control" type="number" value="{{ $nextPurchaseOrderC }}" readonly>
                                        </div>
                                    </div>
                                    <!-- Date -->
                                    <div class="">
                                        <label for="Date" class="">Date</label>
                                        <div class="">
                                            <input id="date" name="date" class="form-control" type="date">
                                        </div>
                                    </div>
                                    <!-- Supplier -->
                                    <div>
                                        <label for="Supplier" class="">Supplier Name</label>
                                        <div class="">
                                                <select id="supplier" name="supplier" class="custom-select" aria-label="Default select example">
                                                    <option selected="" value="">Select Supplier</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->code }}">{{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <!-- Family -->
                                    <div class="">
                                        <label for="Family Product" class="">Family</label>
                                        <div class="">
                                                <select name="family" id="groupFamily" class="custom-select" aria-label="Default select example">
                                                    <option selected="" value="">Select Family</option>
                                                    @foreach($families as $family)
                                                        <option value="{{ $family->family }}">{{ $family->family }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <!-- Product -->
                                    <div>
                                        <label for="product" class="">Product Name</label>
                                        <div class="row mb-3">
                                            <div class="form-group col-sm">
                                                <select id="product" name="product" class="custom-select" aria-label="Default select example">
                                                    <option selected="" value="">Select Product</option>    
                                                    <!-- @foreach($products as $product) -->
                                                        <!-- <option value="{{ $product->code }}">{{ $product->name }}</option> -->
                                                    <!-- @endforeach -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Stock Pick -->
                                    <div>
                                        <label for="P.O Number" class="">Stock(Pic/Kg)</label>
                                        <div class="row mb-3">
                                            <div class="form-group col-sm">
                                                <input id="stock" name="stock" class="form-control" type="number" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="d-flex align-items-center">
                                    <div id="btnAddPOD" class="btn btn-secondary btn-rounded waves effect waves-light">Add</div>
                                </div>
                            </div>
                            <table id="tablePOD">
                                <thead>
                                    <tr>
                                        <th>Code Product</th>
                                        <th>PSC/KG</th>
                                        <th>UM</th>
                                        <th>Tax Rate Code</th>
                                        <th>Unit Price</th>
                                        <th>Description</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr rows="4">
                                        <td colspan="6">Discount</td>
                                        <td><input type="number" name="discount" id="" class="input-numbers"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Purchase Order Total</td>
                                        <td><input type="number" name="totalPrice" id="" class="input-numbers" disabled></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Observations -->
                            <div class="row mb-3">
                                <div class="form-group col-sm-20">
                                    <textarea name="observation" class="form-control" type="text" placeholder="Write here purchase order observation"></textarea>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="">
                                <div class="">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Make Order">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#myForm').validate({
            rules: {
                date: {
                    required: true,
                },
                supplier: {
                    required: true,
                },
            },
            messages: {
                supplier: {
                    required: 'Please Enter Supplier.',
                },
                date: {
                    required: 'Please Enter Date.',
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });

        document.getElementById("groupFamily").addEventListener("change", filterProductsByFamilies);
        function filterProductsByFamilies() {
            console.clear();
            const selectedFamily = this.value;

            fetch(`/products-by-family?family=${selectedFamily}`)
            .then(response => response.json())
            .then(data => {
                const productSelect = document.getElementById('product');

                // Limpa as opções atuais
                productSelect.innerHTML = '<option selected value="">Select Product</option>';

                // Adiciona as novas opções
                data.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.code;
                    option.textContent = product.name;
                    productSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erro ao buscar produtos:', error));
        }

        function calculateTotal(stockInput, priceInput) {
            const stock = parseFloat(stockInput.value) || 0; // Valor de stock ou 0
            const price = parseFloat(priceInput.value) || 0; // Valor de preço ou 0

            const total = stock * price; // Calcula o total
            const row = stockInput.closest('tr'); // Linha atual
            const totalInput = row.querySelector('[name$="[totalPrice]"]'); // Campo totalPrice

            totalInput.value = total.toFixed(2); // Atualiza o total com 2 casas decimais
        }


        document.getElementById("btnAddPOD").addEventListener("click", addRow);
        function addRow() {
            console.clear();

            const table = document.getElementById("tablePOD").getElementsByTagName("tbody")[0];

            const productCodeSelect = document.getElementById('product');
            const selectedValue = productCodeSelect.value;

            const stockSelect = document.getElementById('stock');
            const stockValue = stockSelect.value;

            if (!selectedValue) {
                console.error("Nenhum produto selecionado");
                return;
            }

            fetch(`/product-by-selected?product=${selectedValue}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Erro ao buscar produto: " + response.status);
                }
                return response.json();
            })
            .then(product => {
                console.log("Dados do produto retornados: ", product)

                const rowPOD = table.insertRow(0);        // (0) Insere no topo
                const rowPODCell1 = rowPOD.insertCell(0);
                const rowPODCell2 = rowPOD.insertCell(1);
                const rowPODCell3 = rowPOD.insertCell(2);
                const rowPODCell4 = rowPOD.insertCell(3);
                const rowPODCell5 = rowPOD.insertCell(4);
                const rowPODCell6 = rowPOD.insertCell(5);
                const rowPODCell7 = rowPOD.insertCell(6);
                const rowPODCell8 = rowPOD.insertCell(7);
                
                rowPODCell1.innerHTML = `<input type="hidden" name="products[${table.rows.length - 2}][code]" value="${product.code}">${product.code}`;
                rowPODCell2.innerHTML = `<input type="number" name="products[${table.rows.length - 2}][stock]" value="" class="input-numbers">`;
                rowPODCell3.innerHTML = `<input type="hidden" name="products[${table.rows.length - 2}][unit]" value="${product.unit}">${product.unit || "N/A"}`;
                rowPODCell4.innerHTML = `<input type="hidden" name="products[${table.rows.length - 2}][taxRateCode]" value="${product.taxRate}">${product.taxRate + "%" || "N/A"}`;
                rowPODCell5.innerHTML = `<input type="number" name="products[${table.rows.length - 2}][price]" value="" class="input-numbers">`;
                rowPODCell6.textContent = product.description || "No description";
                rowPODCell7.innerHTML = `<input type="number" name="products[${table.rows.length - 2}][totalPrice]" value="" class="input-numbers" step="0.01" disabled>`;
                rowPODCell8.innerHTML = `<button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()"><i class="fa fa-times"></i></button>`;
            })
            .catch(error => console.error("Erro ao buscar produtos:", error));
        }
    });
</script>
@endsection
