@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Buat Resep Baru</h2>
        <form id="resepForm" action="{{ route('reseps.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_racikan">Nama Racikan (Optional)</label>
                <input type="text" name="nama_racikan" class="form-control" id="nama_racikan">
            </div><br><br>

            <div class="form-group">
                <h4>Detail Resep</h4>
                <div id="details" class="row">
                    <div class="col-md-4">
                        <div class="card detail mb-3">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="obat_id">Pilih Obat</label>
                                    <select id="obatSelect" name="details[0][obat_id][]" class="form-control obatSelect">
                                        <option value="" data-stok="">Silahkan pilih obat</option>
                                        @foreach ($obats as $obat)
                                            <option value="{{ $obat->obatalkes_id }}" data-stok="{{ $obat->stok }}">
                                                {{ $obat->obatalkes_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="text" class="form-control stockInput" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="number" name="details[0][qty][]" class="form-control qtyInput">
                                </div>
                                <div class="form-group">
                                    <label for="signa_id">Signa</label>
                                    <select name="details[0][signa_id]" class="form-control signaSelect">
                                        <option value="">Silahkan pilih signa</option>
                                        @foreach ($signas as $signa)
                                            <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success mt-5" id="addDetail">Tambah Obat</button>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Resep</button>
        </form>
    </div>

    <script>
        function attachChangeEvent(selectElement) {
            selectElement.addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var stok = selectedOption.getAttribute('data-stok');
                var stockInput = this.closest('.detail').querySelector('.stockInput');

                if (stok !== null) {
                    stok = parseFloat(stok).toFixed(0);
                    stockInput.value = stok;
                } else {
                    stockInput.value = ''; 
                }
            });
        }

        function attachDeleteEvent(deleteButton) {
            deleteButton.addEventListener('click', function() {
                this.closest('.col-md-4').remove();
                updateFormIndexes();
            });
        }

        document.getElementById('addDetail').addEventListener('click', function() {
            let details = document.getElementById('details');
            let detailTemplate = details.firstElementChild.cloneNode(true);
            let index = details.children.length;

            detailTemplate.querySelectorAll('select, input').forEach(function(element) {
                if (element.classList.contains('obatSelect')) {
                    element.id = 'obatSelect_' + index;
                }
                element.name = element.name.replace(/\[\d+\]/, '[' + index + ']');
                if (!element.classList.contains('stockInput')) {
                    element.value = ''; 
                }
            });

            if (index > 0) {
                let deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'btn-close deleteDetail';
                deleteButton.setAttribute('aria-label', 'Close');
                deleteButton.style.position = 'absolute';
                deleteButton.style.top = '10px';
                deleteButton.style.right = '10px';
                detailTemplate.querySelector('.card-body').appendChild(deleteButton);

                attachDeleteEvent(deleteButton);
            }

            details.appendChild(detailTemplate);

            let newSelect = detailTemplate.querySelector('.obatSelect');
            attachChangeEvent(newSelect);
        });

        document.getElementById('resepForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var isValid = validateForm();

            if (!isValid) {
                return false;
            }

            this.submit();
        });

        function validateForm() {
            var valid = true;
            var errorMessage = '';

            var namaRacikan = document.getElementById('nama_racikan').value;
            if (!namaRacikan) {
                errorMessage += 'Nama Racikan harus diisi.\n';
                valid = false;
            }

            var detailInputs = document.querySelectorAll('.detail');
            detailInputs.forEach(function(detail) {
                var obatSelect = detail.querySelector('.obatSelect');
                var qtyInput = detail.querySelector('.qtyInput');
                var signaSelect = detail.querySelector('.signaSelect');

                var obatId = obatSelect.value;
                var qty = parseInt(qtyInput.value);
                var stok = parseInt(obatSelect.options[obatSelect.selectedIndex].getAttribute('data-stok'));
                var signaId = signaSelect.value;

                if (!obatId) {
                    errorMessage += 'Obat harus dipilih.\n';
                    valid = false;
                }

                if (!qty || qty <= 0 || isNaN(qty)) {
                    errorMessage += 'Quantity harus lebih dari 0.\n';
                    valid = false;
                } else if (qty > stok) {
                    errorMessage += 'Quantity melebihi stok.\n';
                    valid = false;
                }

                if (!signaId) {
                    errorMessage += 'Signa harus dipilih.\n';
                    valid = false;
                }
            });

            if (!valid) {
                alert(errorMessage);
            }

            return valid;
        }

        function updateFormIndexes() {
            let details = document.getElementById('details');
            let detailCards = details.querySelectorAll('.col-md-4');
            detailCards.forEach((detail, index) => {
                detail.querySelectorAll('select, input').forEach(function(element) {
                    element.name = element.name.replace(/\[\d+\]/, '[' + index + ']');
                    if (element.classList.contains('obatSelect')) {
                        element.id = 'obatSelect_' + index;
                    }
                });
            });
        }

        attachChangeEvent(document.getElementById('obatSelect'));
    </script>
@endsection
