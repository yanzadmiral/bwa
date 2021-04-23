const express = require('express');
const router = express.Router();
const verifyTokenRouter = require("../middleware/verifyToken");

const handlermedia = require('./handler/users');
/* GET users listing. */
router.post('/register', handlermedia.register);
router.post('/login', handlermedia.login);
router.put('/update',verifyTokenRouter, handlermedia.update);

module.exports = router;
