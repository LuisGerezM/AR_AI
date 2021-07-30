<!DOCTYPE html>
<html>
<script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
<!-- we import arjs version without NFT but with marker + location based support -->
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>

<style>
    /* ## Colors

### Primary

- Dark Blue (intro and email sign up background): hsl(217, 28%, 15%)
- Dark Blue (main background): hsl(218, 28%, 13%)
- Dark Blue (footer background): hsl(216, 53%, 9%)
- Dark Blue (testimonials background): hsl(219, 30%, 18%)

### Accent

- Cyan (inside call-to-action gradient): hsl(176, 68%, 64%)
- Blue (inside call-to-action gradient): hsl(198, 60%, 50%)
- Light Red (error): hsl(0, 100%, 63%)

### Neutral

- White: hsl(0, 0%, 100%) */

    .button {
        color: hsl(0, 0%, 100%);
        padding: 9px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        font-weight: bold;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 12px;
        border: 2px solid hsl(176, 68%, 64%);
        outline: none;
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        transition: background-color 0.2s ease-out,
            color 0.2s ease-out;
    }

    .button:hover,
    .button:active {
        background-color: hsl(176, 68%, 64%);
        /* color: hsl(0, 0%, 100%); */
        color: hsl(216, 53%, 9%);
        padding: 9px;
        border-color: hsl(219, 30%, 18%);
        font-weight: bold;
        font-size: 12px;
        transition: background-color 0.3s ease-in,
            color 0.3s ease-in;
    }
</style>

<?php

$arrayNameModel = [];
$arrayId = [];

// simulamos el array de objeto que recibimos

// Tabla que definí, versión 1.1
// id, tareas_id, grupos_formados_id, name_file, path, type, ext, observacion 

// El array que voy a recibir será aproximadamente este:
// tareas_id = array(
//     grupos_formados_id= array(
//         file = array (
//             name_file => ...,
//             path => 'year/asig_id/grupos_id/num_grupo/nombre_archivo',
//             type => ...
//         )
//     )
// )

// Por ejemplo:
// 43 = array(
//     117 = array(
//         file = array (
//             name_file => ...,            
//             path => ....,
//             type => ...
//         )
//     ),
//     118 = array(
//         file = array (
//             name_file => ...,            
//             path => ....,
//             type => ...
//         )
//     ),
//     119 = array(
//         file = array (
//             name_file => ...,            
//             path => ....,
//             type => ...
//         )
//     ),
//     120 = array(
//         file = array (
//             name_file => ...,            
//             path => ....,
//             type => ...
//         )
//     )  
// )

$arr = array(
    117 => array(
        'file'  => array(
            'name_file' => 1,
            'path' => '../models/2021/17/43/1/1.gltf',
            'type' => 'img',
            'ext'  =>  'gltf'
        )
    ),
    118 => array(
        'file'  => array(
            'name_file' => 2,
            'path' => '../models/2021/17/43/2/2.obj',
            'type' => 'img',
            'ext'  =>  'obj'
        )
    ),
    119 => array(
        'file'  => array(
            'name_file' => 3,
            'path' => '../models/2021/17/43/3/3.mp4',
            'type' => 'video',
            'ext'  =>  'mp4'
        )
    ),
    120 => array(
        'file' => array(
            'name_file' => 4,
            'path' => '../models/2021/17/43/4/4.gltf',
            'type' => 'img',
            'ext'  =>  'gltf'
        )
    )
);

$i = 1;
foreach ($arr as $k => $v) {
    $arrayId['Group' . $i] = $v['file']['name_file'];
    $i++;
}

?>

<!-- <body> -->
<div style='position: fixed; top: 10px; width:100%; text-align: center; z-index: 1;'>

    <!-- Botones en la parte superior creados Dinamicamente -->
    <?php
    foreach ($arrayId as $k => $v) :
    ?>
        <!-- dejamos este btn con 'a' para darle el estilo de transpariencia -->
        <a class="button" id=<?php echo $v ?> onclick="clickBtn(<?php echo $v ?>)"> <?php echo $k ?> </a>

    <?php
    endforeach;
    ?>

</div>

<!-- esta es la Aplicación AR como tal -->

<body style="margin : 0px; overflow: hidden;">


    <!-- HABILITAR a-escene DESPUES     -->
    <a-scene embedded arjs="debugUIEnabled: false;" vr-mode-ui="enabled: false">

        <a-marker preset="hiro" id="marker"></a-marker>

        <!-- HABILITAR CAMARA DESPUES -->
        <a-entity camera></a-entity>
    </a-scene>
</body>

<!-- Creamos los Botones y los EVENTOS -->
<script>
    const arrayInit = []

    var aMarker = document.querySelector('#marker')
    var buttons = document.querySelectorAll('.buttons')

    // despues sacar esto y ver como hacer dinamico los botones
    var btn1 = document.querySelector('#btn1')
    var btn2 = document.querySelector('#btn2')

    eventListeners()

    function eventListeners() {
        document.addEventListener('DOMContentLoaded', startedApp)
        // document.querySelector('#btn1').addEventListener('click', clickBtnOne)
    }

    function startedApp() {

        // Pasamos el array de PHP a un array de objetos (arrayInit) en JS

        <?php
        foreach ($arr as $k => $v) :
        ?>
            // Armamos el array de objetos
            arrayInit.push({
                grupos_formados_id: <?php echo $k; ?>,
                file: {
                    name_file: <?php echo $arr[$k]['file']['name_file']; ?>,
                    path: '<?php echo $arr[$k]['file']['path']; ?>',
                    type: '<?php echo $arr[$k]['file']['type']; ?>',
                    ext: '<?php echo $arr[$k]['file']['ext']; ?>'
                }
            })

        <?php
        endforeach;
        ?>


        // Creamos el la rimera entidad para el inicio de la app
        const elementStart = document.createElement("a-entity")
        elementStart.id = "entityId"
        elementStart.setAttribute("gltf-model",
            '../models/modelsGltf/Duck/Duck.gltf');
        elementStart.setAttribute("scale", '.5 .5 .5');
        elementStart.setAttribute("rotation", '00 270 70')
        elementStart.setAttribute("position", '0 0 0')
        aMarker.appendChild(elementStart)
    }

    // gltf u obj
    function isImg(fileSelected) {
        //console.log('fileSelected', fileSelected)

        const {
            ext,
            path
        } = fileSelected

        // Limpiamos HTML (si es q tocamos un btn antes)
        limpiarHTML()

        // armamos el nuevo modelo
        const newModel = document.createElement("a-entity")
        newModel.id = "entityId"

        if (ext === 'obj') {
            //console.log('es imagen obj')
            newModel.setAttribute("obj-model", `obj:url(${path})`);
            newModel.setAttribute("rotation", '115 100 100')

        } else if (fileSelected.ext === 'gltf') {
            //console.log('es gltf')
            newModel.setAttribute(`${ext}-model`,
                `${path}`);
            newModel.setAttribute("rotation", '100 70 70')

        } else {
            console.log('Error, extensión de img no reconocida ')
        }

        // newModel.setAttribute("scale", '.50 .50 .50');
        // newModel.setAttribute("scale", '.70 .70 .70');
        newModel.setAttribute("scale", '.90 .90 .90');
        newModel.setAttribute("position", '0 0 0')
        aMarker.appendChild(newModel)
        //console.log('newModel', newModel)
    }

    // Video
    function isVideo(fileSelected) {
        console.log('idVideo')

        const {
            type,
            path
        } = fileSelected

        // console.log('type', type)
        // console.log('path', path)
        limpiarHTML()

        // Creamos entidad VIDEO
        // const elementV = document.createElement('video')
        const elementV = document.createElement(type)
        elementV.id = type
        elementV.setAttribute("src", path);
        elementV.setAttribute('croosOrigin', "anonymous")
        elementV.setAttribute("scale", '10 10 10');
        console.log('elementV', elementV)
        aMarker.appendChild(elementV)

        const newElement = document.createElement("a-video")
        newElement.id = "entityId"
        // newElement.setAttribute("src",
        //     '../models/videoMp4/laLlave-AbelPintos-xmi.mp4');
        newElement.setAttribute("src",
            '#video');
        newElement.setAttribute("rotation", '270 0 0')
        newElement.setAttribute("position", '0 0 0')
        aMarker.appendChild(newElement)

    }

    var statusVideo = document.querySelector("a-marker")

    statusVideo.addEventListener("markerFound", (e) => {

        // Añadiendo accion a video
        var aVideo = document.querySelector("a-video")

        if (aVideo !== null) {
            var v = document.querySelector("#video").play();
        }
    })

    statusVideo.addEventListener("markerLost", (e) => {
        // Añadiendo accion a video
        var aVideo = document.querySelector("a-video")

        if (aVideo !== null) {
            var v = document.querySelector("#video").pause();
        }
    })

    function clickBtn(clickButtonId) {
        limpiarHTML()

        let fileSelected
        let i = 0
        let exist = false
        while (i < arrayInit.length && !exist) {
            if (arrayInit[i].file.name_file === clickButtonId) {
                //console.log(" si " + arrayInit[i].file.name_file)

                // aqui ya tenemos la info del btn seleccionado
                fileSelected = arrayInit[i].file
                exist = true;
            }
            i++
        }

        showModel(fileSelected)

    }

    // funcion para mostrar el modelo que fue seleccionado
    function showModel(fileSelected) {
        console.log('fileSelected showModel', fileSelected)

        if (fileSelected.type === 'video') {
            // console.log('es video')
            isVideo(fileSelected)
        } else if (fileSelected.type = "img") {
            isImg(fileSelected)
        } else {
            console.log('error formato de imagen no reconocido')
        }

    }

    function limpiarHTML() {
        while (aMarker.firstChild) {
            aMarker.removeChild(aMarker.firstChild)
        }
    }
</script>


</html>