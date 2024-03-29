USE [nGestao3]
GO

/****** Object:  Table [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL]    Script Date: 10/07/2020 15:01:52 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL](
	[CD_ID] [int] IDENTITY(1,1) NOT NULL,
	[CD_USUARIO] [int] NOT NULL,
	[CD_USUARIOAT] [int] NOT NULL,
	[CD_EMPRESA] [int] NOT NULL,
	[CD_FILIAL] [int] NOT NULL,
	[DT_ATUALIZACAO] [datetime] NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_DT_ATUALIZACAO]  DEFAULT (getdate()),
	[DT_CADASTRO] [datetime] NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_DT_CADASTRO]  DEFAULT (getdate()),
	[DT_ANO] [varchar](5) NOT NULL,
	[VL_TOTAL_ANO] [decimal](18, 2) NOT NULL,
	[VL_MES_JAN] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_JAN]  DEFAULT ((0)),
	[VL_MES_FEV] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_FEV]  DEFAULT ((0)),
	[VL_MES_MAR] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_MAR]  DEFAULT ((0)),
	[VL_MES_ABR] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_ABR]  DEFAULT ((0)),
	[VL_MES_MAI] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_MAI]  DEFAULT ((0)),
	[VL_MES_JUN] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_JUN]  DEFAULT ((0)),
	[VL_MES_JUL] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_JUL]  DEFAULT ((0)),
	[VL_MES_AGO] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_AGO]  DEFAULT ((0)),
	[VL_MES_SET] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_SET]  DEFAULT ((0)),
	[VL_MES_OUT] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_OUT]  DEFAULT ((0)),
	[VL_MES_NOV] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_NOV]  DEFAULT ((0)),
	[VL_MES_DEZ] [decimal](18, 2) NOT NULL CONSTRAINT [DF_TBL_NEWNORTE_ORCAMENTO_ANUAL_VL_MES_DEZ]  DEFAULT ((0)),
	[CD_CENTRO_CUSTO] [int] NOT NULL,
	[CD_CONTA_GERENCIAL] [int] NOT NULL,
	[DS_OBS] [varchar](500) NULL,
 CONSTRAINT [PK_TBL_NEWNORTE_ORCAMENTO_ANUAL_1] PRIMARY KEY CLUSTERED 
(
	[CD_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 80) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_CONTA_GERENCIAL] FOREIGN KEY([CD_CONTA_GERENCIAL], [CD_EMPRESA])
REFERENCES [dbo].[TBL_CONTABIL_PLANO_CONTAS_GERENCIAL] ([CD_CONTA_GERENCIAL], [CD_EMPRESA])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL] CHECK CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_CONTA_GERENCIAL]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_EMPRESA] FOREIGN KEY([CD_EMPRESA])
REFERENCES [dbo].[TBL_EMPRESAS] ([CD_EMPRESA])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL] CHECK CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_EMPRESA]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_FILIAL] FOREIGN KEY([CD_FILIAL])
REFERENCES [dbo].[TBL_EMPRESAS_FILIAIS] ([CD_FILIAL])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL] CHECK CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_FILIAL]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_USUARIO] FOREIGN KEY([CD_USUARIO])
REFERENCES [dbo].[TBL_USUARIOS] ([CD_CODUSUARIO])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL] CHECK CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_USUARIO]
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL]  WITH CHECK ADD  CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_USUARIOAT] FOREIGN KEY([CD_USUARIOAT])
REFERENCES [dbo].[TBL_USUARIOS] ([CD_CODUSUARIO])
GO

ALTER TABLE [dbo].[TBL_NEWNORTE_ORCAMENTO_ANUAL] CHECK CONSTRAINT [FK_TBL_NEWNORTE_ORCAMENTO_ANUAL_CD_USUARIOAT]
GO


