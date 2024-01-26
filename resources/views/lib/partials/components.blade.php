<script>
    function redirectToKasir() {
        window.location.href = "{{ route('kasir-penjualan.index') }}";
    }

    function redirectToPelanggan() {
        window.location.href = "{{ route('daftar-pelanggan.index') }}";
    }

    function redirectToPetugas() {
        window.location.href = "{{ route('data-petugas.index') }}";
    }

    function redirectToProduk() {
        window.location.href = "{{ route('data-produk.index') }}";
    }
</script>

<script>
    var greetingElement = document.getElementById('greeting');
    var currentTime = new Date().getHours();

    if (currentTime >= 5 && currentTime < 12) {
        greetingElement.innerHTML = 'Selamat <span class="text-yellow-500">Pagi</span>';
    } else if (currentTime >= 12 && currentTime < 16) {
        greetingElement.innerHTML = 'Selamat <span class="text-yellow-500">Siang</span>';
    } else if (currentTime >= 16 && currentTime < 19) {
        greetingElement.innerHTML = 'Selamat <span class="text-yellow-500">Sore</span>';
    } else {
        greetingElement.innerHTML = 'Selamat <span class="text-yellow-500">Malam</span>';
    }
</script>

<script>
    const selectedProducts = [];
    let isMember = false; // Variable to store member status

    function addToTransaction(productName, price, productId) {
        const existingProduct = selectedProducts.find(product => product.name === productName);

        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            selectedProducts.push({
                id: productId,
                name: productName,
                price: price,
                quantity: 1
            });
        }

        updateTransactionUI();
    }


    function removeFromTransaction(productName) {
        const index = selectedProducts.findIndex(product => product.name === productName);

        if (index !== -1) {
            selectedProducts.splice(index, 1);
        }

        updateTransactionUI();
    }

    function toggleMemberStatus() {
        isMember = !isMember; // Toggle member status
        updateTransactionUI();
    }

    function updateTransactionUI() {
        const transactionDetails = document.getElementById('transaction-details');
        const totalPriceInput = document.getElementById('total-price');

        // Clear previous content
        transactionDetails.innerHTML = '';

        // Update the UI on the right side with selected products and total price
        selectedProducts.forEach(product => {
            const productElement = document.createElement('div');
            productElement.className = 'flex justify-between items-center';
            productElement.innerHTML = `
            <input type="hidden" name="produk_id[]" value="${product.id || ''}">
            <div class="product">
                <p class="text-sm font-semibold">${product.name}</p>
                <p class="text-sm">${product.quantity} x ${product.price.toFixed(2)}</p>
                <input type="hidden" name="jumlah_produk[]" value="${product.quantity}">
            </div>
            <div class="value">
                <p class="text-sm font-semibold">${(product.quantity * product.price).toFixed(2)}</p>
                <input type="hidden" name="subtotal[]" value="${(product.quantity * product.price).toFixed(2)}">
                <button onclick="removeFromTransaction('${product.name}')" class="text-sm text-red-500">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </div>
        `;

            // Wrap hr inside a container
            const hrContainer = document.createElement('div');
            hrContainer.className = 'my-2';
            hrContainer.appendChild(document.createElement('hr'));

            // Append both the product element and hr container
            transactionDetails.appendChild(productElement);
            transactionDetails.appendChild(hrContainer);
        });

        // Calculate and display total price in the input
        const totalPrice = selectedProducts.reduce((total, product) => total + (product.quantity * product.price), 0);

        // Get the selected customer ID
        const pelangganId = document.getElementById('pelanggan_id').value;

        // Check if a customer is selected and apply a discount
        const discountPercentage = pelangganId ? 30 : 0; // Assuming a 30% discount for members
        const discountedTotal = totalPrice - (totalPrice * (discountPercentage / 100));

        totalPriceInput.value = `${discountedTotal.toFixed(2)}`;

        // Update the product indicators
        updateProductIndicators();
    }


    function updateProductIndicators() {
        const productIndicators = document.querySelectorAll('.product-indicator');

        productIndicators.forEach(indicator => {
            const productName = indicator.dataset.productName;
            const product = selectedProducts.find(p => p.name === productName);

            if (product) {
                indicator.textContent = product.quantity;
                indicator.style.display = 'block';
            } else {
                indicator.textContent = '0';
                indicator.style.display = 'none';
            }
        });
    }

    // Update the UI when the customer selection changes
    document.getElementById('pelanggan_id').addEventListener('change', updateTransactionUI);
</script>

<script>
    function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>

@if (session('tambahMember_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Pelanggan Berhasil Menjadi Member!"
            });
        });
    </script>
@endif
@if (session('petugas_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Petugas Berhasil di Register!"
            });
        });
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dataId = button.getAttribute('data-id');

                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda Yakin Petugas ini Dihapus?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
                    confirmButtonColor: 'red',
                    denyButtonText: `<i class="fa fa-times"></i> Batal`,
                    denyButtonColor: 'grey',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById(`delete-form-${dataId}`);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@if (session('deletePetugas_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Petugas Berhasil di Hapus!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@endif
@if (session('deletePetugas_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@endif
@if (session('tambahProduk_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Produk Berhasil di Tambah!"
            });
        });
    </script>
@endif
@if (session('tambahProduk_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Terjadi Kesalahan!"
            });
        });
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button-2');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dataId = button.getAttribute('data-id-2');

                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda Yakin Produk ini Dihapus?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
                    confirmButtonColor: 'red',
                    denyButtonText: `<i class="fa fa-times"></i> Batal`,
                    denyButtonColor: 'grey',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById(`delete-form-2-${dataId}`);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@if (session('deleteProduk_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Produk Berhasil di Hapus!"
            });
        });
    </script>
@endif
@if (session('deleteProduk_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Terjadi Kesalahan!"
            });
        });
    </script>
@endif
@if (session('updateProduk_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Produk Berhasil di Edit!"
            });
        });
    </script>
@endif
@if (session('updateProduk_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Terjadi Kesalahan!"
            });
        });
    </script>
@endif
@if (session('penjualan_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Transaksi Penjualan Berhasil!"
            });
        });
    </script>
@endif
