const express = require('express');
const router = express.Router();
const verifyToken = require("../middleware/verifyToken");
const handlermedia = require('./handler/courses');
const can = require("../middleware/permission");
/* GET users listing. */
router.get('/', handlermedia.getall);
router.get('/:id', handlermedia.get);

router.post('/', verifyToken,can('admin'),handlermedia.create);
router.put('/:id', verifyToken,can('admin'),handlermedia.update);
router.delete('/:id', verifyToken,can('admin'),handlermedia.destroy);

module.exports = router;
