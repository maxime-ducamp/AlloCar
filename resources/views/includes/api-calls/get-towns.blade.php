<script>
    const inputs = {
        departureInput: {
            field: document.getElementById('departureInput'),
            resultsField: document.getElementById('departureAxiosResults'),
            previousValue: null,
        },
        arrivalInput: {
            field: document.getElementById('arrivalInput'),
            resultsField: document.getElementById('arrivalAxiosResults'),
            previousValue: null,
        }
    };

    let timeout = null;

    let values = Object.values(inputs);

    values.forEach(value => {
        value.field.addEventListener('keyup', handleInput);
        // value.field.addEventListener('blur', function () {
        //     clearTimeout(timeout);
        //     value.resultsField.innerHTML = '';
        // })
    });


    /**
     * Checks if the previous input is different than the current one
     * If true, calls a function to send a request to external API
     */
    function handleInput(event) {

        let eventInput = inputs[`${event.target.name}Input`];

        clearTimeout(timeout);

        let currentValue = event.target.value,
            previousValue = eventInput.previousValue;

        timeout = setTimeout(function () {
            if (currentValue.length > 2 && currentValue !== previousValue) {
                previousValue = currentValue;
                eventInput.previousValue = currentValue;
                checkForTown(currentValue, eventInput);
            }
        }, 1000);
    }

    /**
     * Clears the results field from previous values if any and sends an ajax request
     * Calls a function to repopulate the results field
     * @param currentValue
     * @param eventInput
     */
    function checkForTown(currentValue, eventInput) {
        eventInput.resultsField.innerHTML = '';
        let url = 'https://geo.api.gouv.fr/communes?nom=' + currentValue + '&fields=departement,population';

        axios.get(url).then((res) => {

            let results = res.data.sort((current, next) => {
                return current.population < next.population ? 1 : -1;
            });

            results = results.slice(0, 9);

            new Promise(function (resolve) {
                resolve(results.forEach((item) => {
                    appendResult(item, eventInput.resultsField);
                }));
            }).then(function () {
                /**
                 * Selects the previously appended divs and adds an event listener to each
                 */
                let divs = document.querySelectorAll("[data-result-value]");

                /** Used to populate the input field with the suggested town name */
                divs.forEach(div => {
                    div.addEventListener('click', function () {
                        eventInput.field.value = this.getAttribute('data-result-value');
                        eventInput.resultsField.innerHTML = '';
                    });
                });
            });

        });
    }

    /**
     * Defines the markup for a result
     * @param item
     * @param resultsField
     */
    function appendResult(item, resultsField) {
        let div = document.createElement('div'),
            p = document.createElement('p'),
            i = document.createElement('i');

        p.innerHTML = `${item.nom} (${item.departement.code})`;
        p.classList.add('axios-search-suggestion');
        i.className = "fas fa-chevron-right text-blue text-xl";


        div.setAttribute('data-result-value', item.nom);
        div.appendChild(p);
        div.appendChild(i);

        div.className = "flex justify-between items-center cursor-pointer";

        resultsField.appendChild(div);
    }
</script>
