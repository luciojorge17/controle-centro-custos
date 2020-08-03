select cd_usuario_reprovou, DT_AUTORIZACAO from tbl_compras_ordem_compra where cd_ordem_compra = 161

update TBL_COMPRAS_ORDEM_COMPRA set CD_USUARIO_AUTORIZOU = null, DT_AUTORIZACAO = null where CD_ORDEM_COMPRA = 161