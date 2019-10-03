@extends('base')

@section('stylesheets')
    <style>
        .autocomplete {
            /*the container must be positioned relative:*/
            position: relative;
            display: inline-block;
        }

        input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        input[type=text] {
            background-color: #f1f1f1;
            width: 100%;
        }

        input[type=submit] {
            background-color: DodgerBlue;
            color: #fff;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
@endsection
@section('content')
    <form autocomplete="off" action="" id="form">
        <div class="autocomplete" style="width:300px;">
            <input id="myInput" type="text" name="myCountry" placeholder="Country">
            <ul id="axios-results" style="display:none"></ul>
        </div>
        <input type="submit" value="Valider" id="submit">
    </form>
@endsection

@section('bottom_scripts')
    <script>
        let form = document.getElementById('form'),
            input = document.getElementById('myInput'),
            previousInputValue = null,
            timeout = null,
            submit = document.getElementById('submit'),
            results = document.getElementById('axios-results'),
            resultsHidden = true;


        form.addEventListener('submit', (e) => {
            e.preventDefault();
        });

        input.addEventListener('keyup', handleInput);

        /**
         * Checks if the previous input is different than the curent one
         * If true, calls a function to send a request to external API
         */
        function handleInput() {
            let currentValue = input.value;

            clearTimeout(timeout);

            timeout = setTimeout(function () {
                if (currentValue.length > 2 && currentValue !== previousInputValue) {
                    previousInputValue = currentValue;
                    checkForTown(currentValue);
                }
            }, 1000);
        }

        /**
         * Clears the results field from previous values and send an axios request
         * Calls a function to repopulate the results field
         * @param currentValue
         */
        function checkForTown(currentValue) {
            results.innerHTML = '';

            let url = 'https://geo.api.gouv.fr/communes?nom=' + currentValue + '&fields=departement&limit=5';

            axios.get(url).then((res) => {

                if (resultsHidden) {
                    results.style.display = 'block';
                    resultsHidden = false;
                }

                /**
                 * Adds an event listener to all newly created buttons
                 */
                new Promise(function(resolve, reject) {
                   resolve(res.data.forEach((item) => {
                       appendResult(item);
                   }));
                }).then(function() {
                    let buttons = document.querySelectorAll('.form-result-button');

                    buttons.forEach(button => {
                       button.addEventListener('click', function() {
                            input.value = this.getAttribute('data-result-value');
                       });
                    });
                });
            });
        }

        /**
         * Defines the markup for a result
         * @param item
         */
        function appendResult(item) {
            let div = document.createElement('div'),
                p = document.createElement('p'),
                button = document.createElement('button');

            p.innerHTML = item.nom + ' (' + item.departement.code + ')';
            button.innerHTML = "Valider";
            button.className = 'button form-result-button';
            button.setAttribute('data-result-value', item.nom);

            div.appendChild(p);
            div.appendChild(button);

            div.className = "flex justify-between items-center w-full";

            results.appendChild(div);
        }

    </script>
@endsection