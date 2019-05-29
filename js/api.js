(function() {

    let input = document.getElementById('searchMTG');

    input.addEventListener('change', (evt) => {

        document.location = document.location + `?cardname=${evt.target.value}`;

    });

})();