USE [nGestao3]
GO

/****** Object:  Table [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO]    Script Date: 10/07/2020 15:01:34 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO](
	[CD_ID] [int] IDENTITY(1,1) NOT NULL,
	[CD_USUARIO] [int] NOT NULL,
	[CD_USUARIOAT] [int] NOT NULL,
	[CD_CODUSUARIO] [int] NOT NULL,
	[CD_EMPRESA] [int] NOT NULL,
	[CD_FILIAL] [int] NULL,
	[DT_ATUALIZACAO] [datetime] NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_DT_ATUALIZACAO]  DEFAULT (getdate()),
	[DT_CADASTRO] [datetime] NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_DT_CADASTRO]  DEFAULT (getdate()),
	[CD_CENTRO_CUSTO] [int] NOT NULL,
	[CD_CONTA_GERENCIAL] [int] NOT NULL,
	[DS_OBS] [varchar](500) NULL,
 CONSTRAINT [PK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO] PRIMARY KEY CLUSTERED 
(
	[CD_CODUSUARIO] ASC,
	[CD_CENTRO_CUSTO] ASC,
	[CD_CONTA_GERENCIAL] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 80) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_CODUSUARIO] FOREIGN KEY([CD_USUARIO])
REFERENCES [dbo].[TBL_USUARIOS] ([CD_CODUSUARIO])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO] CHECK CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_CODUSUARIO]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_CONTA_GERENCIAL] FOREIGN KEY([CD_CONTA_GERENCIAL], [CD_EMPRESA])
REFERENCES [dbo].[TBL_CONTABIL_PLANO_CONTAS_GERENCIAL] ([CD_CONTA_GERENCIAL], [CD_EMPRESA])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO] CHECK CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_CONTA_GERENCIAL]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_EMPRESA] FOREIGN KEY([CD_EMPRESA])
REFERENCES [dbo].[TBL_EMPRESAS] ([CD_EMPRESA])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO] CHECK CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_EMPRESA]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_FILIAL] FOREIGN KEY([CD_FILIAL])
REFERENCES [dbo].[TBL_EMPRESAS_FILIAIS] ([CD_FILIAL])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO] CHECK CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_FILIAL]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_USUARIO] FOREIGN KEY([CD_USUARIO])
REFERENCES [dbo].[TBL_USUARIOS] ([CD_CODUSUARIO])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO] CHECK CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_USUARIO]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_USUARIOAT] FOREIGN KEY([CD_USUARIOAT])
REFERENCES [dbo].[TBL_USUARIOS] ([CD_CODUSUARIO])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_CENTRO_CUSTO_USUARIO] CHECK CONSTRAINT [FK_TBL_NEWNORTE_CENTRO_CUSTO_USUARIO_CD_USUARIOAT]
GO


