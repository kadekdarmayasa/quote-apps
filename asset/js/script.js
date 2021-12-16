const search = document.getElementById('search');
const keyword = document.getElementById('keyword');
const quotes = document.getElementById('quotes')

keyword.addEventListener('keydown', function() {
    // instance object ajax
    let xhr = new XMLHttpRequest();

    // check kesiapan objek ajax
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            quotes.innerHTML = xhr.responseText;
        }
    }

    // ajax execution
    xhr.open("GET", `ajax/quote.php?keyword=`+keyword.value, true);
    xhr.send();
});