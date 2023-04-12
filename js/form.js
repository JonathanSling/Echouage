function ajaxRequest(type, url, callback, data = null)
{
  let xhr;

  xhr = new XMLHttpRequest();
  if (type == 'GET' && data != null)
    url += '?' + data;
  xhr.open(type, url);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = () =>
  {
    switch (xhr.status)
    {
      case 200:
      case 201:
        console.log(xhr.responseText);
        callback(JSON.parse(xhr.responseText));
        break;
      default:
        return;
    }
  };

  xhr.send(data);
}

function Update(id)
{
    let error = false;
    document.querySelector(".alert-danger").innerHTML = "Erreur de saisie :";
    if(inputs[1].value != '' && (inputs[1].value > new Date().getFullYear().toString() || inputs[1].value < "1950")){
        document.querySelector(".alert-danger").innerHTML += " Date invalide";
        error = true;
    }
    if(isNaN(inputs[2].value.toString()) || (inputs[2].value != '' && inputs[2].value < "1")){
        document.querySelector(".alert-danger").innerHTML += " Individus invalide";
        error = true;
    }
    if(!error){
        inputs.forEach(elem => {
            if(elem.value == ''){
                elem.value = elem.placeholder;
            }
        })
        let data = "id=" + id + "&espece=" + inputs[0].value.toString() + "&date=" + inputs[1].value.toString() + "&nb=" + inputs[2].value.toString() + "&zone=" + inputs[3].value.toString();
        ajaxRequest('PUT', './ajax/request.php/', (resp) => {
            form.style.display = 'none';
            document.querySelector(".alert-danger").style.display = 'none';
            document.querySelector(".alert").innerHTML = 'Cétacé n°' + id + ' modifié avec succès !';
            document.querySelector(".alert").classList.add("onview");
        }, data);
        return 1;
    }else{
        document.querySelector(".alert-danger").style.display = 'block';
    }
}

let form = document.querySelector(".form");
let inputs = form.querySelectorAll("input");

document.getElementById("close").addEventListener("click", () => {
    form.style.display = 'none';
    document.querySelector(".alert-danger").style.display = 'none';
    inputs.forEach(elem => {
        elem.value = '';
    })
});

document.getElementById("confirm").addEventListener("click", () => {
    if(!window.location.toString().includes("details.php")){
        if(Update(id)){
            fields = document.getElementById(id).querySelectorAll("td");
            fields[2].innerHTML = inputs[0].value;
            fields[1].innerHTML = inputs[1].value;
            fields[4].innerHTML = inputs[2].value;
            fields[3].innerHTML = inputs[3].value;
            setTimeout(inputs.forEach(elem => {
                elem.value = '';
            }), 0);
        }
    }else{
        if(Update(window.location.toString().split("=")[1])){
            //details -> modif de l'espece (get ?)
            inputs.forEach(elem => {
                elem.value = '';
            });
        }
    }
});

if(window.location.toString().includes("details.php")){
    document.querySelector(".edit-form").addEventListener("click", () => {
        form.style.display = 'block';
        document.querySelector(".alert").classList.remove("onview");
    });
}

document.querySelectorAll(".click").forEach(elem => {
    elem.querySelector("button").addEventListener("click", () => {
        event.stopPropagation();
        if(!window.location.toString().includes("details.php")){
            id = elem.id;
            fields = elem.querySelectorAll("td");

            form.querySelector("h5").innerHTML = "Modif cétacé n°" + id;
            inputs[0].placeholder = fields[2].innerHTML;
            inputs[1].placeholder = fields[1].innerHTML;
            inputs[2].placeholder = fields[4].innerHTML;
            inputs[3].placeholder = fields[3].innerHTML;
        }
        form.style.display = 'block';
        document.querySelector(".alert").classList.remove("onview");
    });

    elem.addEventListener("click", () => {
        window.location = '/echouage/details.php?id=' + elem.id;
    });
});