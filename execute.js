document.getElementById("execute").addEventListener("click", function() { 
    var id = document.getElementById("execute").value;
    var language = document.getElementById("languageSelect").value;
    var code = document.getElementById("source_code").value;
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("source_code").innerText = this.responseText;
            alert(this.responseText);
        }
    };
    xhttp.open("POST", "output.php?id=" + id + "&language=" + language + "&code=" + encodeURIComponent(code), true);
    xhttp.send();   
  });
  