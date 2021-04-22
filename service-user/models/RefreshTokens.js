module.exports = (sequelize, DataTypes) => {
  const RefreshTokens = sequelize.define(
    "RefreshTokens",
    {
      id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,
        allowNull: false,
      },
      token: {
        type: DataTypes.TEXT,
        allowNul: false,
      },
      user_id: {
        type: DataTypes.INTEGER,
        allowNul: false,
      },
      createdAt: {
        field: "created_at",
        type: DataTypes.DATE,
        allowNul: false,
      },
      updatedAt: {
        field: "updated_at",
        type: DataTypes.DATE,
        allowNul: false,
      },
    },
    {
      tableName: "refresh_tokens",
      tamestaps: true,
    }
  );
  return RefreshTokens;
};
