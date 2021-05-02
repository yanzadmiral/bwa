const express = require('express');
const router = express.Router();
const handlermedia = require('./handler/image-courses');
/* GET users listing. */
router.post('/',handlermedia.create);
router.delete('/:id',handlermedia.destroy);

module.exports = router;
