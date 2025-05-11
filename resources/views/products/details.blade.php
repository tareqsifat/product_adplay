@extends('products.layouts.layout')
@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">FashionHub</h1>
        <div class="position-relative fs-4">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge bg-primary">3</span>
        </div>
    </div>
    <!-- Main Content -->
    <div class="row">
        <div class="col-md-6">
            <img src="{{asset('assets/img/product_single.png')}}" class="img-fluid mb-3" alt="Product Image">
            <div class="d-flex">
                @for ($i = 0; $i < 4; $i++) <img src="{{asset('assets/img/product_alt'.$i.'.png')}}" class="img-thumbnail me-2"
                    alt="thumb">
                @endfor
            </div>
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>

            <!-- Display price -->
            <h4 id="price" class="text-primary fw-bold">
                ${{ number_format($product->skus[0]->unit_amount, 2) }}
            </h4>

            <!-- Static review example -->
            <div id="reviews" class="mb-2">
                <i class="fas fa-star text-warning"></i> 4.8 (67 Reviews)
            </div>

            <!-- Attribute Options -->
            @foreach ($attributes as $attribute)
            <div class="mb-3">
                <label>{{ $attribute['name'] }}:</label>
                <div class="btn-group">
                    @foreach ($attribute['values'] as $value)
                        <button type="button" class="btn btn-outline-primary attr-btn" data-attr="{{ $attribute['name'] }}"
                            data-value="{{ $value['value'] }}" data-price="{{ $value['price'] }}">
                            {{ $value['value'] }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Quantity Selector -->
            <div class="mb-3">
                <label class="form-label fw-bold">Quantity</label>
                <div class="input-group w-25">
                    <button class="btn btn-outline-secondary" id="decrease">-</button>
                    <input type="text" class="form-control text-center" id="qty" value="1" readonly>
                    <button class="btn btn-outline-secondary" id="increase">+</button>
                </div>
            </div>

            <!-- Add to Cart Button with Total Price -->
            <button class="btn btn-primary w-100 mt-4" id="addCartBtn">
                <span id="totalPrice">$--.--</span> Add to Cart
            </button>

            <!-- Hidden SKU Data -->
            <input type="hidden" id="skuData" value='@json($skus)' />
        </div>

    </div>
    <!-- Description Tab -->
    <div class="mt-5">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" href="#description" data-bs-toggle="tab">Description</a>
            </li>
        </ul>
        <div class="tab-content p-4 bg-white border border-top-0">
            <div class="tab-pane fade show active" id="description">
                <h5>Product Description</h5>
                <p>When it's colder than the far side of the moon and spitting rain too, you'll still got to look
                    good...</p>
                <h5>Benefits</h5>
                <ul>
                    <li>Durable leather is easily cleanable so you can keep your look fresh.</li>
                    <li>Water-repellent finish and internal membrane help keep your feet dry.</li>
                    <li>Toe piece with star pattern adds durability.</li>
                    <li>Synthetic insulation helps keep you warm.</li>
                    <li>Originally designed for performance hoops, the Air unit delivers lightweight cushioning.
                    </li>
                    <li>Plush tongue wraps over the ankle to help keep out the moisture and cold.</li>
                    <li>Rubber outsole with aggressive traction pattern adds durable grip.</li>
                    <li>Durable leather is easily cleanable so you can keep your look fresh.</li>
                </ul>
                <h5>Product Details</h5>
                <ul>
                    <li>Not intended for use as Personal Protective Equipment (PPE)</li>
                    <li>Water-repellent finish and internal membrane help keep your feet dry.</li>
                </ul>
                <h5>More Details</h5>
                <ul>
                    <li>Lunarlon midsole delivers ultra-plush responsiveness</li>
                    <li>Encapsulated Air-Sole heel unit for lightweight cushioning</li>
                    <li>Colour Shown: Ale Brown/Black/Goldtone/Ale Brown</li>
                    <li>Style: 805899-202</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const skuData = JSON.parse(document.getElementById('skuData').value);
        let selectedAttrs = {};
        let quantity = 1;




        // Helper to find matching SKU
        function findMatchingSku() {
            return skuData.find(sku => {
                return Object.keys(selectedAttrs).every(attr => {
                    return sku.attributes[attr]?.value == selectedAttrs[attr];
                });
            });
        }
        function updatePrice() {
            const matchingSku = findMatchingSku();

            if (matchingSku) {
                const attrPrices = Object.values(matchingSku.attributes).reduce((sum, attr) => {
                    return sum + parseFloat(attr.price || 0);
                }, 0);
                const basePrice = attrPrices;
                const totalPrice = basePrice * quantity;
                console.log(document.getElementById('totalPrice'));

                document.getElementById('price').innerText = `$${basePrice.toFixed(2)}`;
                document.getElementById('totalPrice').innerText = `$${totalPrice.toFixed(2)}`;
                document.getElementById('addCartBtn').innerText = `$${totalPrice.toFixed(2)} Add To Cart`;
            } else {
                document.getElementById('price').innerText = `$--.--`;
                document.getElementById('totalPrice').innerText = `$--.--`;
                document.getElementById('addCartBtn').innerText = `Add To Cart`;
            }
        }

        // On attribute click
        document.querySelectorAll('.attr-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const attr = this.dataset.attr;
                const value = this.dataset.value;
                selectedAttrs[attr] = value;
console.log(selectedAttrs);

                document.querySelectorAll(`.attr-btn[data-attr="${attr}"]`).forEach(el => el.classList.remove('active'));
                this.classList.add('active');

                updatePrice();
            });
        });

        // Quantity handlers
        document.getElementById('increase').addEventListener('click', () => {
            quantity++;
            document.getElementById('qty').value = quantity;
            updatePrice();
        });

        document.getElementById('decrease').addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                document.getElementById('qty').value = quantity;
                updatePrice();
            }
        });

        // Initial selection (first SKU)
        function initDefaultSelection() {
            if (skuData.length > 0) {
                const firstSku = skuData[0];
                for (const [attr, data] of Object.entries(firstSku.attributes)) {
                    selectedAttrs[attr] = data.value;

                    // Add active class if matching button exists
                    const btn = document.querySelector(`.attr-btn[data-attr="${attr}"][data-value="${data.value}"]`);
                    if (btn) btn.classList.add('active');
                }
                updatePrice();
            }
        }

        initDefaultSelection();
    });

</script>
@endpush


@endsection
