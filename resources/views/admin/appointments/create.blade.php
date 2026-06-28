@extends('admin.layouts.admin')


@section('content')
<style>
    <style>
:root{
  --bg:         #EEF4FB;
  --white:      #FFFFFF;
  --blue:       #2D7DD2;
  --blue-l:     #E8F1FB;
  --blue-d:     #1A5BA8;
  --blue-mid:   #4A9AE8;
  --border:     #D6E4F5;
  --border-f:   #2D7DD2;
  --text:       #1A2B42;
  --text2:      #4A6080;
  --text3:      #8FA8C4;
  --green:      #16A96A;
  --green-bg:   #E8F8F2;
  --amber:      #D08020;
  --amber-bg:   #FEF5E7;
  --rose:       #E55A6B;
  --rose-bg:    #FDEEF0;
  --info:       #2D7DD2;
  --info-bg:    #E8F1FB;
  --violet:     #7C5CCC;
  --violet-bg:  #F0ECFB;
  --ease:       cubic-bezier(0.16,1,0.3,1);
}

</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Book Appointment for {{ $patient->name }}</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.appointments.store') }}" method="POST">
                @csrf

                <input type="hidden"
                       name="patient_id"
                       value="{{ $patient->id }}">

                <div class="mb-3">
                    <label>Patient</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $patient->name }}"
                           readonly>
                </div>

                <div class="mb-3">
                    <label>Select Doctor</label>
                    <select name="doctor_id"
                            id="doctor_id"
                            class="form-control"
                            required>
                        <option value="">Select Doctor</option>

                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">
                                Dr. {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select Date</label>
                    <input type="date"
                           id="appointment_date"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Available Slots</label>
                    <div id="slot_container"></div>
                </div>

                <div class="mb-3">
                    <label>Problem Description</label>
                    <textarea name="problem_description"
                              class="form-control"></textarea>
                </div>

                <button class="btn btn-primary">
                    Book Appointment
                </button>

            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

$('#doctor_id, #appointment_date').change(function(){

    let doctor_id = $('#doctor_id').val();
    let date = $('#appointment_date').val();

    if(!doctor_id || !date){
        return;
    }

    $.ajax({
        url: "{{ route('admin.doctor.slots') }}",
        type: "GET",
        data: {
            doctor_id: doctor_id,
            date: date
        },

        success: function(response){

            let html = '';

            response.data.forEach(function(slot){

                html += `
                    <div class="form-check mb-2">
                        <input type="radio"
                               name="time_slot_id"
                               value="${slot.id}"
                               required>

                        ${slot.start_time} - ${slot.end_time}
                    </div>
                `;
            });

            $('#slot_container').html(html);
        }
    });

});

</script>
@endsection