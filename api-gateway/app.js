require("dotenv").config();
const express = require("express");
const path = require("path");
const cookieParser = require("cookie-parser");
const logger = require("morgan");

const indexRouter = require("./routes/index");
const usersRouter = require("./routes/users");
const coursesRouter = require("./routes/courses");
const mediaRouter = require("./routes/media");
const ordersRouter = require("./routes/orders");
const paymentsRouter = require("./routes/payments");
const chaptersRouter = require('./routes/chapters');
const refreshTokensRouter = require("./routes/refreshTokens");
const verifyToken = require("./middleware/verifyToken");
const MentorsRouter = require("./routes/mentors");

const app = express();

app.use(logger("dev"));
app.use(express.json({ limit: "50mb" }));
app.use(express.urlencoded({ extended: false, limit: "50mb" }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, "public")));

app.use("/", indexRouter);
app.use("/users", usersRouter);
app.use("/courses", coursesRouter);
app.use("/media", mediaRouter);
app.use("/orders", ordersRouter);
app.use("/payments", paymentsRouter);
app.use("/chapters", chaptersRouter);
app.use("/refresh-tokens", refreshTokensRouter);
app.use("/mentors", verifyToken, MentorsRouter);

module.exports = app;
