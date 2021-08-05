var aMarker = document.querySelector("#markerA");
var btn1 = document.querySelector("#btn1");
var btn2 = document.querySelector("#btn2");
var aVideo = null;
let click = 0;
let firstClick = false;

// function startedApp() {
//   // Creamos el la primera entidad para el inicio de la app
//   const elementStart = document.createElement("a-entity");
//   elementStart.id = "entityId";
//   elementStart.setAttribute("gltf-model", "assets/models/Duck/Duck.gltf");
//   elementStart.setAttribute("scale", ".5 .5 .5");
//   elementStart.setAttribute("position", "0 0 0");
//   elementStart.setAttribute("class", "clickable");
//   elementStart.setAttribute(
//     "gesture-handler",
//     "'minScale: 0.25; maxScale: 10'"
//   );
//   elementStart.setAttribute("ondblclick", "doubleClickModel()");
//   aMarker.appendChild(elementStart);

// }

eventListeners();
function eventListeners() {
  // document.addEventListener("DOMContentLoaded", startedApp);
  document.querySelector("#btn1").addEventListener("click", clickBtnOne);
  document.querySelector("#btn2").addEventListener("click", clickBtnTwo);
  document.querySelector("#btn3").addEventListener("click", clickBtnThree);
  // document.querySelector(".info")?.addEventListener("click", clickBtnInfo); // YA ABRO EL MODAL DESDE HTML
  // if (document.querySelector(".info")) {
  //   console.log("existe el btn con clase info");
  // } else {
  //   console.log("NO existe el btn con clase info");
  // }
}

// function clickBtnInfo(e) {
//   e.preventDefault();
//   console.log("clickBtnInfo -> Abre MODAL", clickBtnInfo);
//   console.log("clickBtnInfo e", e);
// }

// gltf
function clickBtnOne() {
  // Detectamos doble click

  click++;
  setTimeout(() => {
    if (click > 1) {
      console.log("firstClick en  dbleclick", firstClick);
      if (firstClick) {
        // si ya dió 1 vez un click para mostrar el modelo
        console.log("doble click");
        const selectInfo = document.querySelector(".info");
        selectInfo.style.display = "flex";
        // console.log("info", selectInfo);
        const num = Math.random() * 10;
        console.log("num", num);
        if (num > 5) {
          // console.log("mayor a 5");
          selectInfo.style.justifyContent = "flex-start";
        } else {
          // console.log("no mayor");
          selectInfo.style.justifyContent = "flex-end";
        }
      } else {
        alert(
          "Por favor dar 1 click en uno de los botones de grupo, así poder generar el modelo correspondiente. Luego ya podrás tener acceso a esta función"
        );
      }
      // Reiniciamos bandera
      firstClick = false;
    } else if (click === 1) {
      console.log("un click");
      firstClick = true;
      limpiarHTML();
      // Creamos la entidad del grupo 1
      const newElement = document.createElement("a-entity");
      newElement.id = "entityId";
      newElement.setAttribute(
        "gltf-model",
        "assets/models/2021/17/43/1/1.gltf"
      );
      newElement.setAttribute("scale", ".50 .50 .50");
      newElement.setAttribute("position", "0 0 0");
      newElement.setAttribute("class", "clickable");
      newElement.setAttribute(
        "gesture-handler",
        "'minScale: 0.25; maxScale: 10'"
      );
      aMarker.appendChild(newElement);
    }
    click = 0;
  }, 1000);
}

// Video
function clickBtnTwo() {
  // ... sólo dejo la lógica del 'doble click' en el primer btn, a modo de presentación

  // Al hacer click en otro btn, si 'btn-information' está activo, desactivarlo;
  const selectInfo = document.querySelector(".info");
  if (selectInfo) {
    selectInfo.style.display = "none";
  }

  limpiarHTML();

  // Creamos la entidad del grupo 2
  const elementV = document.createElement("video");
  elementV.id = "video";
  elementV.setAttribute("src", "assets/models/2021/17/43/3/3.mp4");
  elementV.setAttribute("croosOrigin", "anonymous");
  elementV.setAttribute("preload", "auto");
  elementV.setAttribute("response-type", "arraybuffer");
  elementV.setAttribute("scale", "10 10 10");
  aMarker.appendChild(elementV);

  const newElement = document.createElement("a-video");
  newElement.id = "entityId";
  newElement.setAttribute("src", "#video");
  newElement.setAttribute("rotation", "270 0 0");
  newElement.setAttribute("position", "0 0 0");
  newElement.setAttribute("class", "clickable");
  newElement.setAttribute("gesture-handler", "'minScale: 0.25; maxScale: 10'");
  aMarker.appendChild(newElement);
}

// Cuando nuestra camara vea el marcador, va a dar play al video
var statusVideo = document.querySelector("a-marker");

statusVideo.addEventListener("markerFound", (e) => {
  aVideo = document.querySelector("a-video");
  if (aVideo !== null) {
    var v = document.querySelector("#video").play();
  }
});

// si nuestro marcador NO está en pantalla, el video se va a pausar
statusVideo.addEventListener("markerLost", (e) => {
  aVideo = document.querySelector("a-video");
  if (aVideo !== null) {
    var v = document.querySelector("#video").pause();
  }
});

// obj
function clickBtnThree() {
  limpiarHTML();

  // Creamos la entidad del grupo 3
  const elementObj = document.createElement("a-entity");
  elementObj.id = "entityId";
  elementObj.setAttribute(
    "obj-model",
    "obj:url(assets/models/2021/17/43/2/2.obj)"
  );
  elementObj.setAttribute("scale", ".5 .5 .5");
  elementObj.setAttribute("position", "0 0 0");
  elementObj.setAttribute("class", "clickable");
  elementObj.setAttribute("gesture-handler", "'minScale: 0.25; maxScale: 10'");
  aMarker.appendChild(elementObj);
}

function doubleClickModel() {
  console.log("doble click");
}

function limpiarHTML() {
  while (aMarker.firstChild) {
    aMarker.removeChild(aMarker.firstChild);
  }
}
