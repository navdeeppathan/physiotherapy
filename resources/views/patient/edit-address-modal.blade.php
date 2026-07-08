<div class="modal fade" id="editAddressModal{{ $address->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5>Edit Address</h5>

                <button
                    class="close"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form
                    action="{{ route('user.address.update',$address->id) }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <input
                            class="form-control"
                            name="address"
                            value="{{ $address->address }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <input
                            class="form-control"
                            name="city"
                            value="{{ $address->city }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <input
                            class="form-control"
                            name="state"
                            value="{{ $address->state }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <input
                            class="form-control"
                            name="country"
                            value="{{ $address->country }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <input
                            class="form-control"
                            name="postal_code"
                            value="{{ $address->postal_code }}"
                            required>

                    </div>

                    <div class="form-check">

                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="is_default"
                            value="1"
                            {{ $address->is_default ? 'checked' : '' }}>

                        <label>

                            Make Default

                        </label>

                    </div>

                    <button
                        class="btn btn-primary mt-3">

                        Update Address

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>