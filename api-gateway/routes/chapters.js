const express = require('express');
const router = express.Router();
const verifyToken = require("../middleware/verifyToken");
const handlermedia = require('./handler/chapters');
/* GET users listing. */
router.get('/', handlermedia.getall);
router.get('/:id', handlermedia.get);

router.post('/', handlermedia.create);
router.put('/:id', handlermedia.update);
router.delete('/:id', handlermedia.destroy);

module.exports = router;
