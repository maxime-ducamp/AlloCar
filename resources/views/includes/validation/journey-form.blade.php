<script>
    const formData = {
        departure: {
            value: null,
            validation: "required|string"
        },
        arrival: {
            value: null,
            validation: "required|string"
        },
        seats: {
            value: null,
            validation: "required|numeric|min:1|max:8"
        },
        driver_comment: {
            value: null,
            validation: "nullable|string|max:300"
        }
    };

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let departureInput = document.getElementById('departureInput'),
            arrivalInput = document.getElementById('arrivalInput'),
            seatsInput = document.getElementById('seatsInput'),
            driverCommentInput = document.getElementById('driverCommentInput');

        formData.departure.value = departureInput.value;
        formData.arrival.value = arrivalInput.value;
        formData.seats.value = parseInt(seatsInput.value);
        formData.driver_comment.value = driverCommentInput.value;

        const result = validator.validateForm({ formData });

        if (result.errors) {
            if (result.errors.departure) {
                document.querySelector('[name=departure').classList.add('form-input-error');
                document.querySelector('[id=departureError]').innerHTML = result.errors.departure;
            }
            if (result.errors.arrival) {
                document.querySelector('[name=arrival').classList.add('form-input-error');
                document.querySelector('[id=arrivalError]').innerHTML = result.errors.arrival;
            }
            if (result.errors.seats) {
                document.querySelector('[name=seats').classList.add('form-input-error');
                document.querySelector('[id=seatsError]').innerHTML = result.errors.seats;
            }
            if (result.errors.driver_comment) {
                document.querySelector('[name=driver_comment').classList.add('form-input-error');
                document.querySelector('[id=driverCommentError]').innerHTML = result.errors.driver_comment;
            }
        } else {
            form.submit();
        }
    });
</script>