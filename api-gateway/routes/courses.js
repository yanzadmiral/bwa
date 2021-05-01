const express = require('express');
const router = express.Router();

const handlermedia = require('./handler/courses');
/* GET users listing. */
// router.get('/', handlermedia.getall);
// router.get('/:id', handlermedia.get);
router.post('/', handlermedia.create);
router.put('/:id', handlermedia.update);
router.delete('/:id', handlermedia.destroy);

module.exports = router;
