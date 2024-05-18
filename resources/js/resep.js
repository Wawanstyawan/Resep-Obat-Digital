// resep.js
document.getElementById('addDetail').addEventListener('click', function() {
    let details = document.getElementById('details');
    let detail = details.firstElementChild.cloneNode(true);
    let index = details.children.length;
    detail.querySelectorAll('select, input').forEach(function(element) {
        element.name = element.name.replace('[0]', '[' + index + ']');
    });
    details.appendChild(detail);
});

document.getElementById('resepForm').addEventListener('submit', function(event) {
    // Prevent default form submission
    event.preventDefault();

    // Lakukan validasi quantity
    var isValid = validateQuantity();

    // Jika validasi gagal, tampilkan alert
    if (!isValid) {
        alert('Quantity melebihi stok atau stok telah habis!');
        return false; // Form tidak akan dikirim
    }

    // Jika validasi berhasil, kirim formulir
    this.submit();
});

function validateQuantity() {
    var valid = true;
    // Lakukan validasi untuk setiap input quantity
    var detailInputs = document.querySelectorAll('.detail');
    detailInputs.forEach(function(detail) {
        var qtyInput = detail.querySelector('input[name$="[qty][]"]');
        var obatSelect = detail.querySelector('select[name$="[obat_id][]"]');
        var qty = parseInt(qtyInput.value);
        var stok = parseInt(obatSelect.options[obatSelect.selectedIndex].getAttribute('data-stok'));

        if (qty === 0 || isNaN(qty) || qty < 0 || qty > stok) {
            valid = false;
        }
    });
    return valid;
}
