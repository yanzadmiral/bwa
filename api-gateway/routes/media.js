const express = require('express');
const router = express.Router();

const handlermedia = require('./handler/media');
/* GET users listing. */
router.post('/', handlermedia.create);

router.get('/', handlermedia.getall);

router.delete('/:id', handlermedia.destroy);

module.exports = router;
