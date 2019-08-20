import Quagga from 'quagga';

Quagga.init({
    inputStream : {
        name : "Live",
        type : "LiveStream",
        // Or '#yourElement' (optional)
        target: document.querySelector('#camera')
    },
    numOfWorkers: (navigator.hardwareConcurrency ? navigator.hardwareConcurrency : 4),
    decoder : {
        readers: [
            "ean_reader",
            "ean_8_reader"
        ],
        debug: {
            showCanvas: true,
            showPatches: true,
            showFoundPatches: true,
            showSkeleton: true,
            showLabels: true,
            showPatchLabels: true,
            showRemainingPatchLabels: true,
            boxFromPatches: {
                showTransformed: true,
                showTransformedBox: true,
                showBB: true
            }
        }
    }
}, function(err) {
    if (err) {
        console.log(err);
        return
    }
    console.log("Initialization finished. Ready to start");
    Quagga.start();
});

var a=new AudioContext() // browsers limit the number of concurrent audio contexts, so you better re-use'em

function beep(vol, freq, duration){
    var v=a.createOscillator()
    var u=a.createGain()
    v.connect(u)
    v.frequency.value=freq
    v.type="square"
    u.connect(a.destination)
    u.gain.value=vol*0.01
    v.start(a.currentTime)
    v.stop(a.currentTime+duration*0.001)
}



Quagga.onDetected(function (result) {
    beep(100,400, 1000);
    console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
    document.getElementById('codebar').value = result.codeResult.code;
    const form = document.getElementById('formBarcode')
    form.submit()
});

