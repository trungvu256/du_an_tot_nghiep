@extends('web3.layout.master2')
@section('content')

<div id="wrapper"></div>
<div class="main-content-account">
    <!-- Thông báo -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Breadcrumb -->
    <div class="tf-breadcrumb">
        <div class="container">
            <ul class="breadcrumb-list">
                <li class="item-breadcrumb">
                    <a href="{{ route('web.home') }}" class="text">Trang chủ</a>
                </li>
                <li class="item-breadcrumb dot">
                    <span></span>
                </li>
                <li class="item-breadcrumb">
                    <span class="text">Sổ địa chỉ</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3" >
            <div class="user-info">
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('profile') }}" class="user-info-link">
                            <i class="bi bi-person"></i> Thông tin cá nhân
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('donhang.index') }}" class="user-info-link">
                            <i class="bi bi-cart"></i> Đơn hàng của bạn
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('address.index') }}" class="user-info-link">
                            <i class="bi bi-geo-alt"></i> Địa chỉ của bạn
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('web.logout') }}" class="btn btn-light border-dark text-dark btn-sm w-100 hover-logout">
                            ĐĂNG XUẤT
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Address Section -->
        <div class="col-md-9">
            <div class="address-section mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4 " style="margin-top: 0px;">
                    <h6 class=" text-uppercase" style="font-size: 24px; color: #333;">Địa chỉ của bạn</h6>
                    <button class="btn"
    data-bs-toggle="modal" data-bs-target="#addAddressModal"
    style="background-color: white; color: black; border: 1px solid black;"
    onmouseover="this.style.backgroundColor='black'; this.style.color='white';"
    onmouseout="this.style.backgroundColor='white'; this.style.color='black';">
    Thêm địa chỉ
</button>

                </div>

                @forelse ($addresses as $address)
                    <div class="address-item mb-3 p-3 border rounded d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">
                                <strong>Họ tên:</strong> {{ $address->full_name }}
                                @if($address->is_default)
                                    <span class="text-success ms-2">(Địa chỉ mặc định)</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $address->full_address }}</p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> {{ $address->phone }}</p>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Chỉnh sửa địa chỉ</a>
                            <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá địa chỉ này không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger btn btn-link p-0 m-0">Xóa</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" aria-labelledby="editAddressModalLabel{{ $address->id }}" aria-hidden="true" data-bs-backdrop="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('addresses.edit', $address->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h6 class="modal-title " id="editAddressModalLabel{{ $address->id }}">Chỉnh sửa địa chỉ</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="full_name_{{ $address->id }}" class="form-label">Họ tên</label>
                                        <input type="text" name="full_name" id="full_name_{{ $address->id }}" class="form-control" value="{{ $address->full_name }}" required>
                                        @error('full_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone_{{ $address->id }}" class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone_{{ $address->id }}" class="form-control" value="{{ $address->phone }}" required>
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="address_detail_{{ $address->id }}" class="form-label">Địa chỉ chi tiết</label>
                                        <input type="text" name="address_detail" id="address_detail_{{ $address->id }}" class="form-control" value="{{ $address->full_address }}" required>
                                        @error('address_detail')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="province_{{ $address->id }}" class="form-label">Tỉnh/Thành phố</label>
                                        <select name="province" id="province_{{ $address->id }}" class="form-control custom-select" required>
                                            <option value="">---</option>
                                        </select>
                                        @error('province')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="district_{{ $address->id }}" class="form-label">Quận/Huyện</label>
                                        <select name="district" id="district_{{ $address->id }}" class="form-control custom-select" required>
                                            <option value="">---</option>
                                        </select>
                                        @error('district')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="ward_{{ $address->id }}" class="form-label">Phường/Xã</label>
                                        <select name="ward" id="ward_{{ $address->id }}" class="form-control custom-select" required>
                                            <option value="">---</option>
                                        </select>
                                        @error('ward')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default_{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_default_{{ $address->id }}">Đặt là địa chỉ mặc định?</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit"
    class="btn"
    style="background-color: black; color: white; border: 1px solid black; font-weight: 400;"
    onmouseover="this.style.fontWeight='500';"
    onmouseout="this.style.fontWeight='400';">
    Cập nhật địa chỉ
</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
                @empty
                    <p class="text-muted">Chưa có địa chỉ nào. Vui lòng thêm địa chỉ mới!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

    <!-- Modal Form Thêm Địa Chỉ -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title ">Thêm địa chỉ mới</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Họ tên</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="address_detail" class="form-label">Địa chỉ chi tiết</label>
                                <input type="text" name="address_detail" id="address_detail" class="form-control" value="{{ old('address_detail') }}" required>
                                @error('address_detail')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="province" class="form-label">Tỉnh/Thành phố</label>
                                <select name="province" id="province" class="form-control custom-select" required>
                                    <option value="">---</option>
                                </select>
                                @error('province')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="district" class="form-label">Quận/Huyện</label>
                                <select name="district" id="district" class="form-control custom-select" required>
                                    <option value="">---</option>
                                </select>
                                @error('district')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="ward" class="form-label">Phường/Xã</label>
                                <select name="ward" id="ward" class="form-control custom-select" required>
                                    <option value="">---</option>
                                </select>
                                @error('ward')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_default" id="is_default" {{ old('is_default') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_default">Đặt là địa chỉ mặc định?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit"
    class="btn"
    style="background-color: black; color: white; border: 1px solid black; font-weight: 400;"
    onmouseover="this.style.fontWeight='500';"
    onmouseout="this.style.fontWeight='400';">
    Thêm địa chỉ
</button>




                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS để tùy chỉnh giao diện dropdown giống form thanh toán */
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }

    .custom-select {
        position: relative;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>') no-repeat right 10px center;
        background-size: 12px;
        padding-right: 30px;
    }

    .custom-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }

    .custom-select option {
        padding: 8px 10px;
        font-size: 14px;
    }

    .custom-select::-webkit-scrollbar {
        width: 8px;
    }

    .custom-select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-select::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .custom-select::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Loading spinner */
    .loading::after {
        content: 'Đang tải...';
        color: #888;
    }

    /* Tùy chỉnh giao diện danh sách địa chỉ */
    .address-section {
        max-width: 800px;
        margin: 0 auto;
    }

    .btn-add-address {
        background-color: #28a745;
        color: white;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-add-address:hover {
        background-color: #218838;
    }

    .address-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #fff;
        transition: box-shadow 0.3s ease;
    }

    .address-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .address-item p {
        margin-bottom: 5px;
        font-size: 14px;
        color: #333;
    }

    .address-item strong {
        font-weight: 600;
        color: #333;
    }

    .text-success {
        font-size: 14px;
        font-weight: 500;
    }

    .text-primary {
        font-size: 14px;
        color: #007bff !important;
        text-decoration: none;
    }

    .text-primary:hover {
        color: #0056b3 !important;
        text-decoration: underline;
    }

    .text-danger {
        font-size: 14px;
        color: #dc3545 !important;
        text-decoration: none;
    }

    .text-danger:hover {
        color: #c82333 !important;
        text-decoration: underline;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Hàm rút gọn tên (loại bỏ "Thành phố", "Tỉnh", "Quận", "Huyện", "Phường", "Xã")
    function shortenName(name) {
        return name.replace(/^(Thành phố|Tỉnh|Quận|Huyện|Phường|Xã)\s+/i, '');
    }

    // Hàm hiển thị thông báo lỗi
    function showError(message) {
        console.error(message);
        alert(message);
    }

    // Hàm vô hiệu hóa/hiện dropdown và hiển thị trạng thái loading
    function toggleSelectDisabled(select, disabled) {
        select.disabled = disabled;
        if (disabled) {
            select.classList.add('loading');
        } else {
            select.classList.remove('loading');
        }
    }

    // Hàm lấy danh sách Tỉnh/Thành phố
    async function loadProvinces(targetSelect, selectedValue = null) {
        toggleSelectDisabled(targetSelect, true);
        targetSelect.innerHTML = '<option value="">---</option>';
        try {
            const response = await fetch('https://provinces.open-api.vn/api/p/');
            if (!response.ok) throw new Error('Không thể tải danh sách tỉnh/thành: ' + response.statusText);
            const provinces = await response.json();

            provinces.sort((a, b) => shortenName(a.name).localeCompare(shortenName(b.name)));
            provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.code;
                option.text = shortenName(province.name);
                if (selectedValue && province.code == selectedValue) {
                    option.selected = true;
                }
                targetSelect.appendChild(option);
            });
        } catch (error) {
            showError('Lỗi khi lấy danh sách tỉnh/thành phố: ' + error.message);
        } finally {
            toggleSelectDisabled(targetSelect, false);
        }
    }

    // Hàm lấy danh sách Quận/Huyện
    async function loadDistricts(provinceCode, targetSelect, wardSelect, selectedDistrict = null) {
        toggleSelectDisabled(targetSelect, true);
        targetSelect.innerHTML = '<option value="">---</option>';
        wardSelect.innerHTML = '<option value="">---</option>';
        try {
            const response = await fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`);
            if (!response.ok) throw new Error('Không thể tải danh sách quận/huyện: ' + response.statusText);
            const provinceData = await response.json();

            const districts = Array.isArray(provinceData.districts) ? provinceData.districts : [];

            districts.sort((a, b) => shortenName(a.name).localeCompare(shortenName(b.name)));
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.code;
                option.text = shortenName(district.name);
                if (selectedDistrict && district.code == selectedDistrict) {
                    option.selected = true;
                }
                targetSelect.appendChild(option);
            });
        } catch (error) {
            showError('Lỗi khi lấy danh sách quận/huyện: ' + error.message);
        } finally {
            toggleSelectDisabled(targetSelect, false);
        }
    }

    // Hàm lấy danh sách Phường/Xã
    async function loadWards(districtCode, targetSelect, selectedWard = null) {
        toggleSelectDisabled(targetSelect, true);
        targetSelect.innerHTML = '<option value="">---</option>';
        try {
            const response = await fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`);
            if (!response.ok) throw new Error('Không thể tải danh sách phường/xã: ' + response.statusText);
            const districtData = await response.json();

            const wards = Array.isArray(districtData.wards) ? districtData.wards : [];

            wards.sort((a, b) => shortenName(a.name).localeCompare(shortenName(b.name)));
            wards.forEach(ward => {
                const option = document.createElement('option');
                option.value = ward.code;
                option.text = shortenName(ward.name);
                if (selectedWard && ward.code == selectedWard) {
                    option.selected = true;
                }
                targetSelect.appendChild(option);
            });
        } catch (error) {
            showError('Lỗi khi lấy danh sách phường/xã: ' + error.message);
        } finally {
            toggleSelectDisabled(targetSelect, false);
        }
    }

    // Load Tỉnh/Thành phố cho modal thêm địa chỉ
    const addAddressModal = document.getElementById('addAddressModal');
    if (addAddressModal) {
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');

        addAddressModal.addEventListener('shown.bs.modal', function () {
            provinceSelect.innerHTML = '<option value="">---</option>';
            districtSelect.innerHTML = '<option value="">---</option>';
            wardSelect.innerHTML = '<option value="">---</option>';
            loadProvinces(provinceSelect);
        });

        provinceSelect.addEventListener('change', function () {
            const provinceCode = this.value;
            if (provinceCode) {
                loadDistricts(provinceCode, districtSelect, wardSelect);
            } else {
                districtSelect.innerHTML = '<option value="">---</option>';
                wardSelect.innerHTML = '<option value="">---</option>';
            }
        });

        districtSelect.addEventListener('change', function () {
            const districtCode = this.value;
            if (districtCode) {
                loadWards(districtCode, wardSelect);
            } else {
                wardSelect.innerHTML = '<option value="">---</option>';
            }
        });

        const form = addAddressModal.querySelector('form');
        form.addEventListener('submit', function (event) {
            const province = provinceSelect.value;
            const district = districtSelect.value;
            const ward = wardSelect.value;

            if (!province || !district || !ward) {
                event.preventDefault();
                alert('Vui lòng chọn đầy đủ Tỉnh/Thành phố, Quận/Huyện và Phường/Xã!');
            }
        });
    }

    // Load Tỉnh/Quận/Phường cho modal chỉnh sửa địa chỉ
    @foreach ($addresses as $address)
        (function() {
            const editAddressModal = document.getElementById('editAddressModal{{ $address->id }}');
            if (editAddressModal) {
                const provinceSelect = document.getElementById('province_{{ $address->id }}');
                const districtSelect = document.getElementById('district_{{ $address->id }}');
                const wardSelect = document.getElementById('ward_{{ $address->id }}');

                editAddressModal.addEventListener('shown.bs.modal', function () {
                    provinceSelect.innerHTML = '<option value="">---</option>';
                    districtSelect.innerHTML = '<option value="">---</option>';
                    wardSelect.innerHTML = '<option value="">---</option>';
                    loadProvinces(provinceSelect, '{{ $address->province_code }}').then(() => {
                        loadDistricts('{{ $address->province_code }}', districtSelect, wardSelect, '{{ $address->district_code }}').then(() => {
                            loadWards('{{ $address->district_code }}', wardSelect, '{{ $address->ward_code }}');
                        });
                    });
                });

                provinceSelect.addEventListener('change', function () {
                    const provinceCode = this.value;
                    if (provinceCode) {
                        loadDistricts(provinceCode, districtSelect, wardSelect);
                    } else {
                        districtSelect.innerHTML = '<option value="">---</option>';
                        wardSelect.innerHTML = '<option value="">---</option>';
                    }
                });

                districtSelect.addEventListener('change', function () {
                    const districtCode = this.value;
                    if (districtCode) {
                        loadWards(districtCode, wardSelect);
                    } else {
                        wardSelect.innerHTML = '<option value="">---</option>';
                    }
                });

                const form = editAddressModal.querySelector('form');
                form.addEventListener('submit', function (event) {
                    const province = provinceSelect.value;
                    const district = districtSelect.value;
                    const ward = wardSelect.value;

                    if (!province || !district || !ward) {
                        event.preventDefault();
                        alert('Vui lòng chọn đầy đủ Tỉnh/Thành phố, Quận/Huyện và Phường/Xã!');
                    }
                });
            }
        })();
    @endforeach
});
</script>

@endsection