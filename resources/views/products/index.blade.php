@extends('layouts.app')

@section('content')
<style>
    .product-card { background: white; border-radius: 24px; border: 1px solid rgba(0,0,0,0.04); transition: 0.4s; overflow: hidden; }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); border-color: #4f46e5; }
    .badge-cat { background: #f0f3ff; color: #4f46e5; font-size: 0.65rem; font-weight: 800; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; }
    .price-text { font-size: 1.4rem; font-weight: 800; color: #0f172a; }
    .cursor-pointer { cursor: pointer; }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h6 class="text-uppercase fw-bold text-muted small">Inventory Level 1</h6>
            <h1 class="fw-bold display-5" style="letter-spacing: -2px;">Product <span class="text-primary">Nexus</span></h1>
        </div>
        <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#productModal" onclick="resetForm()">
            <i class="bi bi-plus-circle-fill me-2"></i> Deploy Product
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="product-card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="badge-cat">{{ $product->category }}</span>
                    <div class="dropdown">
                        <i class="bi bi-three-dots-vertical text-muted cursor-pointer" data-bs-toggle="dropdown"></i>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-3">
                            <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="editProduct({{ json_encode($product) }})">Edit Item</a></li>
                            <li>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="dropdown-item py-2 text-danger">Delete Item</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <h5 class="fw-bold mb-1">{{ $product->name }}</h5>
                <p class="text-muted small fw-bold mb-4">SKU: {{ $product->sku }}</p>
                
                <div class="d-flex justify-content-between align-items-end">
                    <div class="price-text">${{ number_format($product->price, 2) }}</div>
                    <div class="text-end">
                        <span class="d-block small fw-bold {{ $product->stock < 5 ? 'text-danger' : 'text-muted' }}">
                            {{ $product->stock }} Units
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h3 class="text-muted fw-light">No items found in the Matrix.</h3>
        </div>
        @endforelse
    </div>

    <div class="mt-5">
        {{ $products->links() }}
    </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h3 class="fw-bold" id="modalTitle">Deploy Product</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="productForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">NAME</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6" id="skuDiv">
                            <label class="form-label small fw-bold">SKU CODE</label>
                            <input type="text" name="sku" id="sku" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">CATEGORY</label>
                            <select name="category" id="category" class="form-control">
                                <option value="Electronics">Electronics</option>
                                <option value="Hardware">Hardware</option>
                                <option value="Apparel">Apparel</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">PRICE ($)</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">STOCK</label>
                            <input type="number" name="stock" id="stock" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Confirm Protocol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let pModal;

    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('productModal');
        if (modalElement) {
            pModal = new bootstrap.Modal(modalElement);
        }
    });

    function resetForm() {
        const form = document.getElementById('productForm');
        document.getElementById('modalTitle').innerText = "Deploy Product";
        document.getElementById('methodField').value = "POST";
        form.action = "{{ route('products.store') }}";
        
        // Reset SKU field to editable
        const skuField = document.getElementById('sku');
        skuField.readOnly = false;
        skuField.style.backgroundColor = "white";
        
        form.reset();
    }

    function editProduct(product) {
        if (!pModal) {
            pModal = new bootstrap.Modal(document.getElementById('productModal'));
        }

        document.getElementById('modalTitle').innerText = "Modify Product";
        document.getElementById('methodField').value = "PUT";
        document.getElementById('productForm').action = "/products/" + product.id;
        
        // Fill data
        document.getElementById('name').value = product.name;
        document.getElementById('price').value = product.price;
        document.getElementById('stock').value = product.stock;
        document.getElementById('category').value = product.category;
        
        // Handle SKU: Keep it but make it Read Only so it passes validation
        const skuField = document.getElementById('sku');
        skuField.value = product.sku;
        skuField.readOnly = true;
        skuField.style.backgroundColor = "#e9ecef"; // Gray out background

        pModal.show();
    }
</script>
@endsection