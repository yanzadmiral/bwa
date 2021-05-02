const express = require('express');
const router = express.Router();

const handlermedia = require('./handler/reviews');
/* GET users listing. */
router.post('/', handlermedia.create);
router.put('/:id', handlermedia.update);
router.delete('/:id', handlermedia.destroy);

module.exports = router;
