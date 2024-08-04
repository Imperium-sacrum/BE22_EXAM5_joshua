function fetchAnimals() {
  let xml = new XMLHttpRequest();
  xml.open("GET", "http://localhost:3000/home/scripts.php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);

        // Check if the response has a data property and if it's an array
        if (response.data && Array.isArray(response.data)) {
          let animals = response.data;

          for (let val of animals) {
            document.getElementById("cards").innerHTML += `
<div class="card shadow-sm border-light border-3 rounded" style="width: 18rem;">
    <div class="my-2 d-flex justify-content-center">
        <img src="../${val.photo}" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" alt="${val.name}">
    </div>
    <div class="card-body">
        <h5 class="card-title mb-2 text-primary">${val.name}</h5>
        <p class="card-text"><strong>Age:</strong> ${val.age}</p>
        <p class="card-text"><strong>Description:</strong> ${val.description}</p>
        <hr>
        <div class="mt-3">
            <a href="../details/details.php?v=${val.animal_id}" class="btn btn-warning btn-sm my-1">More Details</a>
            <a href="../adopted.php?v=${val.animal_id}" class="btn btn-success btn-sm my-1">Adopt Now!</a>
        </div>
    </div>
</div>

`;
          }
        } else {
          document.getElementById(
            "cards"
          ).innerHTML = `<h3>No animals found</h3>`;
        }
      } catch (e) {
        console.error("JSON parsing error:", e);
        document.getElementById(
          "cards"
        ).innerHTML = `<h3>Failed to parse JSON</h3>`;
      }
    } else {
      document.getElementById(
        "cards"
      ).innerHTML = `<h3>Failed to load the Animals</h3>`;
    }
  };
  xml.onerror = function () {
    document.getElementById("hi").innerHTML = `<h3>Request failed</h3>`;
  };
  xml.send();
}
fetchAnimals();

function senior(e) {
  e.preventDefault();
  let xml = new XMLHttpRequest();
  xml.open("GET", "http://localhost:3000/home/scripts.php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);

        // Check if the response has a data property and if it's an array
        if (response.data && Array.isArray(response.data)) {
          let animals = response.data;
          let seniorAnimalsFound = false;

          // Limpiar el contenido existente
          document.getElementById("cards").innerHTML = " ";

          for (let val of animals) {
            if (val.age >= 8) {
              seniorAnimalsFound = true;

              document.getElementById("cards").innerHTML += `
<div class="card shadow-sm border-light border-3 rounded" style="width: 18rem;">
    <div class="my-2 d-flex justify-content-center">
        <img src="../${val.photo}" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" alt="${val.name}">
    </div>
    <div class="card-body">
        <h5 class="card-title mb-2 text-primary">${val.name}</h5>
        <p class="card-text"><strong>Age:</strong> ${val.age}</p>
        <p class="card-text"><strong>Description:</strong> ${val.description}</p>
        <hr>
        <div class="mt-3">
            <a href="../details/details.php?v=${val.animal_id}" class="btn btn-warning btn-sm my-1">More Details</a>
            <a href="../adopted.php?v=${val.animal_id}" class="btn btn-success btn-sm my-1">Adopt Now!</a>
        </div>
    </div>
</div>
              `;
            }
          }

          // Si no se encuentran animales mayores
          if (!seniorAnimalsFound) {
            document.getElementById(
              "cards"
            ).innerHTML = `<h3>No senior animals found</h3>`;
          }
        } else {
          document.getElementById(
            "cards"
          ).innerHTML = `<h3>No animals found</h3>`;
        }
      } catch (e) {
        console.error("JSON parsing error:", e);
        document.getElementById(
          "cards"
        ).innerHTML = `<h3>Failed to parse JSON</h3>`;
      }
    } else {
      document.getElementById(
        "cards"
      ).innerHTML = `<h3>Failed to load the Animals</h3>`;
    }
  };
  xml.onerror = function () {
    document.getElementById("cards").innerHTML = `<h3>Request failed</h3>`;
  };
  xml.send();
}

document.getElementById("senior").addEventListener("click", senior);

function allAnimals(e) {
  e.preventDefault();
  let xml = new XMLHttpRequest();
  xml.open("GET", "http://localhost:3000/home/scripts.php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);

        // Check if the response has a data property and if it's an array
        if (response.data && Array.isArray(response.data)) {
          let animals = response.data;
          // Limpiar el contenido existente
          document.getElementById("cards").innerHTML = " ";

          for (let val of animals) {
            document.getElementById("cards").innerHTML += `

<div class="card shadow-sm border-light border-3 rounded" style="width: 18rem;">
    <div class="my-2 d-flex justify-content-center">
        <img src="../${val.photo}" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" alt="${val.name}">
    </div>
    <div class="card-body">
        <h5 class="card-title mb-2 text-primary">${val.name}</h5>
        <p class="card-text"><strong>Age:</strong> ${val.age}</p>
        <p class="card-text"><strong>Description:</strong> ${val.description}</p>
        <hr>
        <div class="mt-3">
            <a href="../details/details.php?v=${val.animal_id}" class="btn btn-warning btn-sm my-1">More Details</a>
            <a href="../adopted.php?v=${val.animal_id}" class="btn btn-success btn-sm my-1">Adopt Now!</a>
        </div>
    </div>
</div>
`;
          }
        } else {
          document.getElementById(
            "cards"
          ).innerHTML = `<h3>No animals found</h3>`;
        }
      } catch (e) {
        console.error("JSON parsing error:", e);
        document.getElementById(
          "cards"
        ).innerHTML = `<h3>Failed to parse JSON</h3>`;
      }
    } else {
      document.getElementById(
        "cards"
      ).innerHTML = `<h3>Failed to load the Animals</h3>`;
    }
  };
  xml.onerror = function () {
    document.getElementById("hi").innerHTML = `<h3>Request failed</h3>`;
  };
  xml.send();
}
document.getElementById("all").addEventListener("click", allAnimals);
