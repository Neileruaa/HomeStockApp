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


Quagga.onDetected(function (result) {
    console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
    document.getElementById('codebar').value = result.codeResult.code;
    const form = document.getElementById('formBarcode')
    form.submit()
});

