const express = require('express');
const router = express.Router();
const verifyToken = require("../middleware/verifyToken");
const handlermedia = require('./handler/courses');
/* GET users listing. */
router.get('/', handlermedia.getall);
router.get('/:id', handlermedia.get);

router.post('/', verifyToken,handlermedia.create);
router.put('/:id', verifyToken,handlermedia.update);
router.delete('/:id', verifyToken,handlermedia.destroy);

module.exports = router;
