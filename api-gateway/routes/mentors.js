const express = require('express');
const router = express.Router();

const handlermedia = require('./handler/mentors');
/* GET users listing. */
router.get('/', handlermedia.getall);
router.get('/:id', handlermedia.get);
router.post('/', handlermedia.create);

module.exports = router;
