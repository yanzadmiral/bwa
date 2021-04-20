const express = require("express");
const router = express.Router();

const isBase64 = require("is-base64");
const Base64Img = require("base64-img");

const { Media } = require("../models");

/* GET users listing. */

router.get("/", async (req, res) => {
  const media = await Media.findAll({
    attributes: ["id", "image"],
  });

  const mapemedia = media.map((m) => {
    m.image = `${req.get("host")}/${m.image}`;
    return m;
  });

  return res.json({
    status: "success",
    data: mapemedia,
  });
});

router.post("/", (req, res) => {
  //res.send('ok brayyy asdasdas');
  const image = req.body.image;

  if (!isBase64(image, { mimeRequired: true })) {
    return res.status(400).json({
      status: "error",
      message: "invalid base 64",
    });
  }

  Base64Img.img(image, "./public/images", Date.now(), async (err, filepath) => {
    if (err) {
      return res.status(400).json({ status: "error", message: err.message });
    }
    const filename = filepath.split("/").pop();
    const media = await Media.create({ image: `images/${filename}` });

    return res.json({
      status: "success",
      data: {
        id: media.id,
        image: `${req.get("host")}/images/${filename}`,
      },
    });
  });
});

module.exports = router;
