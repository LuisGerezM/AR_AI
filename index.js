var aMarker = document.querySelector("#markerA");
var btn1 = document.querySelector("#btn1");
var btn2 = document.querySelector("#btn2");
var aVideo = null;

eventListeners();
function eventListeners() {
  document.addEventListener("DOMContentLoaded", startedApp);
  document.querySelector("#btn1").addEventListener("click", clickBtnOne);
  document.querySelector("#btn2").addEventListener("click", clickBtnTwo);
  document.querySelector("#btn3").addEventListener("click", clickBtnThree);
}

function startedApp() {
  // Creamos el la primera entidad para el inicio de la app
  const elementStart = document.createElement("a-entity");
  elementStart.id = "entityId";
  elementStart.setAttribute("gltf-model", "models/Duck/Duck.gltf");
  elementStart.setAttribute("scale", ".5 .5 .5");
  elementStart.setAttribute("position", "0 0 0");
  elementStart.setAttribute("class", "clickable");
  elementStart.setAttribute(
    "gesture-handler",
    "'minScale: 0.25; maxScale: 10'"
  );
  aMarker.appendChild(elementStart);
}

// gltf
function clickBtnOne() {
  limpiarHTML();

  // Creamos la entidad del grupo 1
  const newElement = document.createElement("a-entity");
  newElement.id = "entityId";
  newElement.setAttribute("gltf-model", "models/2021/17/43/1/1.gltf");
  newElement.setAttribute("scale", ".50 .50 .50");
  newElement.setAttribute("position", "0 0 0");
  newElement.setAttribute("class", "clickable");
  newElement.setAttribute("gesture-handler", "'minScale: 0.25; maxScale: 10'");
  aMarker.appendChild(newElement);
}

// Video
function clickBtnTwo() {
  limpiarHTML();

  // Creamos la entidad del grupo 2
  const elementV = document.createElement("video");
  elementV.id = "video";
  elementV.setAttribute("src", "models/2021/17/43/3/3.mp4");
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
  elementObj.setAttribute("obj-model", "obj:url(./models/2021/17/43/2/2.obj)");
  elementObj.setAttribute("scale", ".5 .5 .5");
  elementObj.setAttribute("position", "0 0 0");
  elementObj.setAttribute("class", "clickable");
  elementObj.setAttribute("gesture-handler", "'minScale: 0.25; maxScale: 10'");
  aMarker.appendChild(elementObj);
}

function limpiarHTML() {
  while (aMarker.firstChild) {
    aMarker.removeChild(aMarker.firstChild);
  }
}
