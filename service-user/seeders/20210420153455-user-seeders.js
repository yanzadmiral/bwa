"use strict";
const bcrypt = require("bcrypt");
module.exports = {
  up: async (queryInterface, Sequelize) => {
    await queryInterface.bulkInsert("users", [
      {
        name: "yayan 1",
        profession: "admin micro",
        role: "admin",
        email: "yayan1@gmail.com",
        password: await bcrypt.hash("rahasia123", 10),
        created_at: new Date(),
        updated_at: new Date(),
      },
      {
        name: "yayan 2",
        profession: "admin micro",
        role: "student",
        email: "yayan2@gmail.com",
        password: await bcrypt.hash("rahasia123ku", 10),
        created_at: new Date(),
        updated_at: new Date(),
      },
    ]);
  },

  down: async (queryInterface, Sequelize) => {
    await queryInterface.bulkDelete("People", null, {});
  },
};
