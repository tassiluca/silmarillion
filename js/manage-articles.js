function filter() {
    // [NOTE] toLowerCase() => **NO** case sensitive filter
    var input = document.getElementById('search').value.toLowerCase();
    var li = document.getElementById('products').getElementsByTagName('li');

    for (let i = 0; i < li.length; i++) {
        let txtValue = li[i].getElementsByTagName('strong')[0]
                            .getElementsByTagName('a')[0].innerText.toLowerCase();
        if (txtValue.indexOf(input) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }

}