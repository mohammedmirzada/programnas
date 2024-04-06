function downloadURI(uri, name, book_id) {
    var link = document.createElement("a");
    link.download = name;
    link.href = uri;
    link.click();
    Functions.PostData('/control/template/php/library/',
        'library=download_book&book_id='+book_id+"&header="+Functions.GetHeaderRequest());
}