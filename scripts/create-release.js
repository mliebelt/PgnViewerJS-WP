const fs = require("fs");
const archiver = require("archiver");
const path = require("path");

const output = fs.createWriteStream("pgnviewerjs-wp.zip");
const archive = archiver("zip", {
  zlib: { level: 9 }, // Sets the compression level.
});

output.on("close", function () {
  console.log(archive.pointer() + " total bytes");
  console.log(
    "archiver has been finalized and the output file descriptor has closed.",
  );
});

archive.on("error", function (err) {
  throw err;
});

archive.pipe(output);

// Add the directories
archive.directory("css/", "css");
archive.directory("js/", "js");

// Add individual files
archive.file("pgnviewerjs.php", { name: "pgnviewerjs.php" });
archive.file("readme.txt", { name: "readme.txt" });

archive.finalize();
