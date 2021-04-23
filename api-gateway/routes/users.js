const express = require('express');
const router = express.Router();

const handlermedia = require('./handler/users');
/* GET users listing. */
router.post('/register', handlermedia.register);
router.post('/login', handlermedia.login);

module.exports = router;
