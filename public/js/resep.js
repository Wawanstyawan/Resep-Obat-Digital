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
    event.preventDefault();

    var isValid = validateQuantity();

    if (!isValid) {
        alert('Quantity melebihi stok atau stok telah habis!');
        return false;
    }

    this.submit();
});

function validateQuantity() {
    var valid = true;
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
