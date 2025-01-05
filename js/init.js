console.log("init.js is being executed");

window.initPGNV = function (mode, id, config) {
  console.log("initPGNV called with:", mode, id, config);

  function callPGNV() {
    if (typeof PGNV !== "undefined" && typeof PGNV[mode] === "function") {
      try {
        PGNV[mode](id, config);
        console.log("PGNV." + mode + " called successfully");
      } catch (error) {
        console.error("Error calling PGNV." + mode + ":", error);
      }
    } else {
      console.error("PGNV or PGNV." + mode + " is not a function");
    }
  }

  if (typeof PGNV !== "undefined") {
    console.log("PGNV is already available, calling function directly");
    callPGNV();
  } else {
    console.log("PGNV not immediately available, setting up event listener");
    let timeout = setTimeout(() => {
      console.error("Timeout waiting for PGNV to load");
    }, 5000); // 5 second timeout

    document.addEventListener(
      "pgnvReady",
      function () {
        clearTimeout(timeout);
        console.log("pgnvReady event triggered");
        callPGNV();
      },
      { once: true },
    );
  }
};

(function () {
  console.log("IIFE: Checking for PGNV");
  var pgnvReadyEvent = new Event("pgnvReady");

  function checkPGNVLoaded() {
    if (typeof PGNV !== "undefined") {
      console.log("IIFE: PGNV object found:", PGNV);
      console.log("IIFE: PGNV methods:", Object.keys(PGNV));
      console.log("IIFE: Dispatching pgnvReady event");
      document.dispatchEvent(pgnvReadyEvent);
    } else {
      console.log("IIFE: PGNV not loaded yet, checking again in 100ms");
      setTimeout(checkPGNVLoaded, 100);
    }
  }

  checkPGNVLoaded();
})();
