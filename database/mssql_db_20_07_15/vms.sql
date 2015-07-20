USE [master]
GO
/****** Object:  Database [vms]    Script Date: 7/20/2015 2:53:14 AM ******/
CREATE DATABASE [vms]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'vms', FILENAME = N'c:\Program Files\Microsoft SQL Server\MSSQL11.SQLEXPRESS\MSSQL\DATA\vms.mdf' , SIZE = 267328KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'vms_log', FILENAME = N'c:\Program Files\Microsoft SQL Server\MSSQL11.SQLEXPRESS\MSSQL\DATA\vms_log.ldf' , SIZE = 297024KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [vms] SET COMPATIBILITY_LEVEL = 110
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [vms].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [vms] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [vms] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [vms] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [vms] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [vms] SET ARITHABORT OFF 
GO
ALTER DATABASE [vms] SET AUTO_CLOSE ON 
GO
ALTER DATABASE [vms] SET AUTO_CREATE_STATISTICS ON 
GO
ALTER DATABASE [vms] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [vms] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [vms] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [vms] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [vms] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [vms] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [vms] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [vms] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [vms] SET  ENABLE_BROKER 
GO
ALTER DATABASE [vms] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [vms] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [vms] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [vms] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [vms] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [vms] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [vms] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [vms] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [vms] SET  MULTI_USER 
GO
ALTER DATABASE [vms] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [vms] SET DB_CHAINING OFF 
GO
ALTER DATABASE [vms] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [vms] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
USE [vms]
GO
/****** Object:  Schema [m2ss]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE SCHEMA [m2ss]
GO
/****** Object:  UserDefinedFunction [dbo].[enum2str$password_change_request$is_used]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[enum2str$password_change_request$is_used] 
( 
   @setval tinyint
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 1 THEN 'YES'
            WHEN 2 THEN 'NO'
            ELSE ''
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[enum2str$visitor$contact_street_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[enum2str$visitor$contact_street_type] 
( 
   @setval tinyint
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 1 THEN 'ALLY'
            WHEN 2 THEN 'APP'
            WHEN 3 THEN 'ARC'
            WHEN 4 THEN 'AVE'
            WHEN 5 THEN 'BLVD'
            WHEN 6 THEN 'BROW'
            WHEN 7 THEN 'BYPA'
            WHEN 8 THEN 'CWAY'
            WHEN 9 THEN 'CCT'
            WHEN 10 THEN 'CIRC'
            WHEN 11 THEN 'CL'
            WHEN 12 THEN 'CPSE'
            WHEN 13 THEN 'CNR'
            WHEN 14 THEN 'CT'
            WHEN 15 THEN 'CRES'
            WHEN 16 THEN 'CRS'
            WHEN 17 THEN 'DR'
            WHEN 18 THEN 'END'
            WHEN 19 THEN 'EESP'
            WHEN 20 THEN 'FLAT'
            WHEN 21 THEN 'FWAY'
            WHEN 22 THEN 'FRNT'
            WHEN 23 THEN 'GDNS'
            WHEN 24 THEN 'GLD'
            WHEN 25 THEN 'GLEN'
            WHEN 26 THEN 'GRN'
            WHEN 27 THEN 'GR'
            WHEN 28 THEN 'HTS'
            WHEN 29 THEN 'HWY'
            WHEN 30 THEN 'LANE'
            WHEN 31 THEN 'LINK'
            WHEN 32 THEN 'LOOP'
            WHEN 33 THEN 'MALL'
            WHEN 34 THEN 'MEWS'
            WHEN 35 THEN 'PCKT'
            WHEN 36 THEN 'PDE'
            WHEN 37 THEN 'PARK'
            WHEN 38 THEN 'PKWY'
            WHEN 39 THEN 'PL'
            WHEN 40 THEN 'PROM'
            WHEN 41 THEN 'RES'
            WHEN 42 THEN 'RDGE'
            WHEN 43 THEN 'RISE'
            WHEN 44 THEN 'RD'
            WHEN 45 THEN 'ROW'
            WHEN 46 THEN 'SQ'
            WHEN 47 THEN 'ST'
            WHEN 48 THEN 'STRP'
            WHEN 49 THEN 'TARN'
            WHEN 50 THEN 'TCE'
            WHEN 51 THEN 'FARETFRE'
            WHEN 52 THEN 'TRAC'
            WHEN 53 THEN 'TWAY'
            WHEN 54 THEN 'VIEW'
            WHEN 55 THEN 'VSTA'
            WHEN 56 THEN 'WALK'
            WHEN 57 THEN 'WWAY'
            WHEN 58 THEN 'WAY'
            WHEN 59 THEN 'YARD'
            ELSE ''
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[enum2str$visitor$identification_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[enum2str$visitor$identification_type] 
( 
   @setval tinyint
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 1 THEN 'PASSPORT'
            WHEN 2 THEN 'DRIVERS_LICENSE'
            WHEN 3 THEN 'PROOF_OF_AGE'
            ELSE ''
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[enum2str$visitor$profile_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[enum2str$visitor$profile_type] 
( 
   @setval tinyint
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 1 THEN 'VIC'
            WHEN 2 THEN 'ASIC'
            WHEN 3 THEN 'CORPORATE'
            ELSE ''
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[enum2str$visitor_card_status$profile_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[enum2str$visitor_card_status$profile_type] 
( 
   @setval tinyint
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 1 THEN 'VIC'
            WHEN 2 THEN 'ASIC'
            WHEN 3 THEN 'CORPORATE'
            ELSE ''
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[norm_enum$password_change_request$is_used]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[norm_enum$password_change_request$is_used] 
( 
   @setval nvarchar(max)
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN dbo.enum2str$password_change_request$is_used(dbo.str2enum$password_change_request$is_used(@setval))
   END
GO
/****** Object:  UserDefinedFunction [dbo].[norm_enum$visitor$contact_street_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[norm_enum$visitor$contact_street_type] 
( 
   @setval nvarchar(max)
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN dbo.enum2str$visitor$contact_street_type(dbo.str2enum$visitor$contact_street_type(@setval))
   END
GO
/****** Object:  UserDefinedFunction [dbo].[norm_enum$visitor$identification_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[norm_enum$visitor$identification_type] 
( 
   @setval nvarchar(max)
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN dbo.enum2str$visitor$identification_type(dbo.str2enum$visitor$identification_type(@setval))
   END
GO
/****** Object:  UserDefinedFunction [dbo].[norm_enum$visitor$profile_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[norm_enum$visitor$profile_type] 
( 
   @setval nvarchar(max)
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN dbo.enum2str$visitor$profile_type(dbo.str2enum$visitor$profile_type(@setval))
   END
GO
/****** Object:  UserDefinedFunction [dbo].[norm_enum$visitor_card_status$profile_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[norm_enum$visitor_card_status$profile_type] 
( 
   @setval nvarchar(max)
)
RETURNS nvarchar(max)
AS 
   BEGIN
      RETURN dbo.enum2str$visitor_card_status$profile_type(dbo.str2enum$visitor_card_status$profile_type(@setval))
   END
GO
/****** Object:  UserDefinedFunction [dbo].[str2enum$password_change_request$is_used]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[str2enum$password_change_request$is_used] 
( 
   @setval nvarchar(max)
)
RETURNS tinyint
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 'YES' THEN 1
            WHEN 'NO' THEN 2
            ELSE 0
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[str2enum$visitor$contact_street_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[str2enum$visitor$contact_street_type] 
( 
   @setval nvarchar(max)
)
RETURNS tinyint
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 'ALLY' THEN 1
            WHEN 'APP' THEN 2
            WHEN 'ARC' THEN 3
            WHEN 'AVE' THEN 4
            WHEN 'BLVD' THEN 5
            WHEN 'BROW' THEN 6
            WHEN 'BYPA' THEN 7
            WHEN 'CWAY' THEN 8
            WHEN 'CCT' THEN 9
            WHEN 'CIRC' THEN 10
            WHEN 'CL' THEN 11
            WHEN 'CPSE' THEN 12
            WHEN 'CNR' THEN 13
            WHEN 'CT' THEN 14
            WHEN 'CRES' THEN 15
            WHEN 'CRS' THEN 16
            WHEN 'DR' THEN 17
            WHEN 'END' THEN 18
            WHEN 'EESP' THEN 19
            WHEN 'FLAT' THEN 20
            WHEN 'FWAY' THEN 21
            WHEN 'FRNT' THEN 22
            WHEN 'GDNS' THEN 23
            WHEN 'GLD' THEN 24
            WHEN 'GLEN' THEN 25
            WHEN 'GRN' THEN 26
            WHEN 'GR' THEN 27
            WHEN 'HTS' THEN 28
            WHEN 'HWY' THEN 29
            WHEN 'LANE' THEN 30
            WHEN 'LINK' THEN 31
            WHEN 'LOOP' THEN 32
            WHEN 'MALL' THEN 33
            WHEN 'MEWS' THEN 34
            WHEN 'PCKT' THEN 35
            WHEN 'PDE' THEN 36
            WHEN 'PARK' THEN 37
            WHEN 'PKWY' THEN 38
            WHEN 'PL' THEN 39
            WHEN 'PROM' THEN 40
            WHEN 'RES' THEN 41
            WHEN 'RDGE' THEN 42
            WHEN 'RISE' THEN 43
            WHEN 'RD' THEN 44
            WHEN 'ROW' THEN 45
            WHEN 'SQ' THEN 46
            WHEN 'ST' THEN 47
            WHEN 'STRP' THEN 48
            WHEN 'TARN' THEN 49
            WHEN 'TCE' THEN 50
            WHEN 'FARETFRE' THEN 51
            WHEN 'TRAC' THEN 52
            WHEN 'TWAY' THEN 53
            WHEN 'VIEW' THEN 54
            WHEN 'VSTA' THEN 55
            WHEN 'WALK' THEN 56
            WHEN 'WWAY' THEN 57
            WHEN 'WAY' THEN 58
            WHEN 'YARD' THEN 59
            ELSE 0
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[str2enum$visitor$identification_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[str2enum$visitor$identification_type] 
( 
   @setval nvarchar(max)
)
RETURNS tinyint
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 'PASSPORT' THEN 1
            WHEN 'DRIVERS_LICENSE' THEN 2
            WHEN 'PROOF_OF_AGE' THEN 3
            ELSE 0
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[str2enum$visitor$profile_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[str2enum$visitor$profile_type] 
( 
   @setval nvarchar(max)
)
RETURNS tinyint
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 'VIC' THEN 1
            WHEN 'ASIC' THEN 2
            WHEN 'CORPORATE' THEN 3
            ELSE 0
         END
   END
GO
/****** Object:  UserDefinedFunction [dbo].[str2enum$visitor_card_status$profile_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE FUNCTION [dbo].[str2enum$visitor_card_status$profile_type] 
( 
   @setval nvarchar(max)
)
RETURNS tinyint
AS 
   BEGIN
      RETURN 
         CASE @setval
            WHEN 'VIC' THEN 1
            WHEN 'ASIC' THEN 2
            WHEN 'CORPORATE' THEN 3
            ELSE 0
         END
   END
GO
/****** Object:  Table [dbo].[access_tokens]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[access_tokens](
	[ID] [int] IDENTITY(11,1) NOT NULL,
	[USER_ID] [int] NOT NULL,
	[ACCESS_TOKEN] [nvarchar](255) NOT NULL,
	[EXPIRY] [datetime2](0) NULL,
	[CLIENT_ID] [int] NOT NULL,
	[CREATED] [datetime2](0) NOT NULL,
	[MODIFIED] [datetime2](0) NOT NULL,
	[USER_TYPE] [int] NULL,
 CONSTRAINT [PK_access_tokens_ID] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[audit_trail]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[audit_trail](
	[id] [bigint] IDENTITY(1145588,1) NOT NULL,
	[description] [nvarchar](255) NULL,
	[old_value] [nvarchar](255) NULL,
	[new_value] [nvarchar](255) NULL,
	[action] [nvarchar](20) NULL,
	[model] [nvarchar](45) NULL,
	[model_id] [bigint] NULL,
	[field] [nvarchar](45) NULL,
	[creation_date] [datetime2](0) NOT NULL,
	[user_id] [nvarchar](45) NULL,
 CONSTRAINT [PK_audit_trail_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[card_generated]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[card_generated](
	[id] [bigint] IDENTITY(2829,1) NOT NULL,
	[card_number] [varchar](10) NULL,
	[date_printed] [date] NULL,
	[date_expiration] [date] NULL,
	[date_cancelled] [date] NULL,
	[date_returned] [date] NULL,
	[card_image_generated_filename] [bigint] NULL,
	[visitor_id] [bigint] NULL,
	[card_status] [bigint] NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[print_count] [bigint] NULL,
 CONSTRAINT [PK_card_generated_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[card_status]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[card_status](
	[id] [bigint] IDENTITY(5,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_card_status_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[card_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[card_type](
	[id] [bigint] IDENTITY(10,1) NOT NULL,
	[name] [varchar](50) NULL,
	[max_day_validity] [int] NULL,
	[max_time_validity] [varchar](50) NULL,
	[max_entry_count_validity] [int] NULL,
	[card_icon_type] [varchar](max) NULL,
	[card_background_image_path] [varchar](max) NULL,
	[created_by] [bigint] NULL,
	[module] [bigint] NULL,
	[back_text] [varchar](max) NULL,
 CONSTRAINT [PK_card_type_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[cardstatus_convert]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cardstatus_convert](
	[id] [int] IDENTITY(3,1) NOT NULL,
	[visitor_id] [bigint] NOT NULL,
	[convert_time] [date] NOT NULL,
 CONSTRAINT [PK_cardstatus_convert_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[company]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[company](
	[id] [bigint] IDENTITY(126,1) NOT NULL,
	[code] [nvarchar](3) NOT NULL,
	[name] [nvarchar](150) NOT NULL,
	[trading_name] [nvarchar](150) NULL,
	[logo] [bigint] NULL,
	[contact] [nvarchar](100) NULL,
	[billing_address] [nvarchar](150) NULL,
	[email_address] [nvarchar](50) NULL,
	[office_number] [varchar](20) NULL,
	[mobile_number] [varchar](50) NULL,
	[website] [nvarchar](50) NULL,
	[company_laf_preferences] [bigint] NULL,
	[created_by_user] [bigint] NULL,
	[created_by_visitor] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [int] NULL,
	[card_count] [bigint] NULL,
	[company_type] [bigint] NULL,
 CONSTRAINT [PK_company_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[company_laf_preferences]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[company_laf_preferences](
	[id] [bigint] IDENTITY(9,1) NOT NULL,
	[action_forward_bg_color] [varchar](7) NULL,
	[action_forward_bg_color2] [varchar](7) NULL,
	[action_forward_font_color] [varchar](7) NULL,
	[action_forward_hover_color] [varchar](7) NULL,
	[action_forward_hover_color2] [varchar](7) NULL,
	[action_forward_hover_font_color] [varchar](7) NULL,
	[complete_bg_color] [varchar](7) NULL,
	[complete_bg_color2] [varchar](7) NULL,
	[complete_hover_color] [varchar](7) NULL,
	[complete_hover_color2] [varchar](7) NULL,
	[complete_font_color] [varchar](7) NULL,
	[complete_hover_font_color] [varchar](7) NULL,
	[neutral_bg_color] [varchar](7) NULL,
	[neutral_bg_color2] [varchar](7) NULL,
	[neutral_hover_color] [varchar](7) NULL,
	[neutral_hover_color2] [varchar](7) NULL,
	[neutral_font_color] [varchar](7) NULL,
	[neutral_hover_font_color] [varchar](7) NULL,
	[nav_bg_color] [varchar](7) NULL,
	[nav_hover_color] [varchar](7) NULL,
	[nav_font_color] [varchar](7) NULL,
	[nav_hover_font_color] [varchar](7) NULL,
	[sidemenu_bg_color] [varchar](7) NULL,
	[sidemenu_hover_color] [varchar](7) NULL,
	[sidemenu_font_color] [varchar](7) NULL,
	[sidemenu_hover_font_color] [varchar](7) NULL,
	[css_file_path] [varchar](50) NULL,
 CONSTRAINT [PK_company_laf_preferences_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[company_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[company_type](
	[id] [int] IDENTITY(4,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_company_type_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[contact_person]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[contact_person](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[contact_person_name] [varchar](50) NOT NULL,
	[contact_person_email] [varchar](50) NOT NULL,
	[contact_person_message] [varchar](100) NULL,
	[date_created] [datetime] NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[country]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[country](
	[id] [int] IDENTITY(751,1) NOT NULL,
	[code] [nchar](2) NOT NULL,
	[name] [nvarchar](45) NOT NULL,
 CONSTRAINT [PK_country_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[cvms_kiosk]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cvms_kiosk](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[workstation] [int] NOT NULL,
	[module] [nvarchar](255) NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[password] [nvarchar](255) NOT NULL,
	[tenant] [int] NOT NULL,
	[tenant_agent] [int] NOT NULL,
	[created_by] [int] NOT NULL,
	[is_deleted] [smallint] NOT NULL,
	[enabled] [smallint] NOT NULL,
 CONSTRAINT [PK_cvms_kiosk_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[files]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[files](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[folder_id] [int] NULL,
	[user_id] [bigint] NULL,
	[file] [varchar](255) NOT NULL,
	[uploaded] [datetime] NULL,
	[size] [float] NULL,
	[ext] [varchar](20) NULL,
	[uploader] [bigint] NULL,
	[name] [varchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[folders]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[folders](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[parent_id] [int] NULL,
	[user_id] [bigint] NULL,
	[default] [tinyint] NULL,
	[name] [varchar](255) NOT NULL,
	[date_created] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[helpdesk]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[helpdesk](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[question] [nvarchar](255) NOT NULL,
	[answer] [nvarchar](max) NOT NULL,
	[helpdesk_group_id] [bigint] NOT NULL,
	[order_by] [int] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [int] NULL,
 CONSTRAINT [PK_helpdesk_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[helpdesk_group]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[helpdesk_group](
	[id] [bigint] IDENTITY(2,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[order_by] [int] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [bigint] NULL,
 CONSTRAINT [PK_helpdesk_group_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[import_hosts]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[import_hosts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[first_name] [nvarchar](50) NOT NULL,
	[last_name] [nvarchar](50) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[department] [nvarchar](50) NOT NULL,
	[staff_id] [nvarchar](50) NOT NULL,
	[contact_number] [nvarchar](50) NOT NULL,
	[company] [nvarchar](50) NOT NULL,
	[imported_by] [int] NULL,
	[date_imported] [date] NULL,
	[password] [nvarchar](50) NOT NULL,
	[role] [int] NULL,
	[position] [nvarchar](50) NULL,
	[date_of_birth] [date] NULL,
 CONSTRAINT [PK_import_hosts_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[import_visitor]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[import_visitor](
	[id] [int] IDENTITY(93,1) NOT NULL,
	[card_code] [nvarchar](255) NULL,
	[first_name] [nvarchar](255) NOT NULL,
	[last_name] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[company] [nvarchar](255) NOT NULL,
	[check_in_date] [date] NULL,
	[check_out_date] [date] NULL,
	[imported_by] [int] NULL,
	[import_date] [date] NULL,
	[check_in_time] [time](7) NULL,
	[check_out_time] [time](7) NULL,
	[position] [nvarchar](30) NULL,
	[date_printed] [date] NULL,
	[date_expiration] [date] NULL,
	[vehicle] [nvarchar](50) NULL,
	[contact_number] [nvarchar](40) NULL,
 CONSTRAINT [PK_import_visitor_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[license_details]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[license_details](
	[id] [bigint] IDENTITY(2,1) NOT NULL,
	[description] [varchar](max) NULL,
 CONSTRAINT [PK_license_details_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[module]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[module](
	[id] [bigint] IDENTITY(3,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[about] [nvarchar](255) NULL,
	[created_by] [datetime2](0) NULL,
 CONSTRAINT [PK_module_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[notification]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[notification](
	[id] [int] IDENTITY(15,1) NOT NULL,
	[subject] [nvarchar](250) NOT NULL,
	[message] [nvarchar](max) NOT NULL,
	[created_by] [int] NULL,
	[date_created] [date] NULL,
	[role_id] [int] NULL,
	[notification_type] [nvarchar](100) NULL,
 CONSTRAINT [PK_notification_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[password_change_request]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[password_change_request](
	[id] [int] IDENTITY(32,1) NOT NULL,
	[user_id] [bigint] NOT NULL,
	[hash] [nvarchar](255) NOT NULL,
	[created_at] [datetime2](0) NOT NULL,
	[is_used] [nvarchar](3) NOT NULL,
 CONSTRAINT [PK_password_change_request_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [password_change_request$hash] UNIQUE NONCLUSTERED 
(
	[hash] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[patient]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[patient](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [varchar](100) NULL,
 CONSTRAINT [PK_patient_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[photo]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[photo](
	[id] [bigint] IDENTITY(913,1) NOT NULL,
	[filename] [varchar](max) NULL,
	[unique_filename] [varchar](max) NULL,
	[relative_path] [varchar](max) NULL,
	[db_image] [varbinary](max) NULL,
 CONSTRAINT [PK_photo_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[reasons]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[reasons](
	[id] [int] IDENTITY(2,1) NOT NULL,
	[reason_name] [nvarchar](50) NOT NULL,
	[date_created] [datetime] NOT NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
 CONSTRAINT [PK_reasons_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[reset_history]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[reset_history](
	[id] [int] IDENTITY(12,1) NOT NULL,
	[visitor_id] [bigint] NOT NULL,
	[reset_time] [datetime2](0) NOT NULL,
	[reason] [nvarchar](250) NOT NULL,
	[lodgement_date] [date] NULL,
 CONSTRAINT [PK_reset_history_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[roles]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[roles](
	[id] [bigint] IDENTITY(15,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_roles_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[tbl_migration]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_migration](
	[version] [nvarchar](255) NOT NULL,
	[apply_time] [int] NULL,
 CONSTRAINT [PK_tbl_migration_version] PRIMARY KEY CLUSTERED 
(
	[version] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[tenant]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tenant](
	[id] [bigint] NOT NULL,
	[created_by] [bigint] NOT NULL,
	[is_deleted] [smallint] NULL,
 CONSTRAINT [PK_tenant_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[tenant_contact]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tenant_contact](
	[id] [bigint] IDENTITY(13,1) NOT NULL,
	[tenant] [bigint] NOT NULL,
	[user] [bigint] NOT NULL,
 CONSTRAINT [PK_tenant_contact_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[timezone]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[timezone](
	[id] [int] IDENTITY(141,1) NOT NULL,
	[timezone_name] [nvarchar](250) NOT NULL,
	[timezone_value] [nvarchar](250) NOT NULL,
 CONSTRAINT [PK_timezone_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[user]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[user](
	[id] [bigint] IDENTITY(1445,1) NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[last_name] [varchar](50) NOT NULL,
	[email] [varchar](50) NOT NULL,
	[contact_number] [varchar](20) NOT NULL,
	[date_of_birth] [date] NULL,
	[company] [bigint] NULL,
	[department] [varchar](50) NULL,
	[position] [varchar](50) NULL,
	[staff_id] [varchar](50) NULL,
	[notes] [varchar](max) NULL,
	[password] [varchar](150) NULL,
	[role] [bigint] NOT NULL,
	[user_type] [bigint] NOT NULL,
	[user_status] [bigint] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [smallint] NOT NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[photo] [bigint] NOT NULL,
	[asic_no] [int] NULL,
	[asic_expiry] [date] NULL,
	[is_required_induction] [smallint] NULL,
	[is_completed_induction] [smallint] NULL,
	[induction_expiry] [date] NULL,
	[timezone_id] [bigint] NOT NULL,
	[allowed_module] [int] NULL,
 CONSTRAINT [PK_user_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user_notification]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_notification](
	[id] [int] IDENTITY(14662,1) NOT NULL,
	[user_id] [int] NULL,
	[notification_id] [int] NULL,
	[has_read] [int] NULL,
	[date_read] [date] NULL,
 CONSTRAINT [PK_user_notification_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[user_status]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[user_status](
	[id] [bigint] IDENTITY(3,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_user_status_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[user_type](
	[id] [bigint] IDENTITY(3,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_user_type_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user_workstation]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_workstation](
	[id] [bigint] IDENTITY(65,1) NOT NULL,
	[user] [bigint] NOT NULL,
	[workstation] [bigint] NOT NULL,
	[created_by] [bigint] NULL,
	[is_primary] [smallint] NOT NULL,
 CONSTRAINT [PK_user_workstation_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[vehicle]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[vehicle](
	[id] [bigint] IDENTITY(60,1) NOT NULL,
	[vehicle_registration_plate_number] [varchar](6) NOT NULL,
 CONSTRAINT [PK_vehicle_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visit]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[visit](
	[id] [bigint] IDENTITY(24598,1) NOT NULL,
	[visitor] [bigint] NULL,
	[card_type] [bigint] NULL,
	[card] [bigint] NULL,
	[visitor_type] [bigint] NULL,
	[reason] [bigint] NULL,
	[visitor_status] [bigint] NULL,
	[host] [bigint] NULL,
	[patient] [bigint] NULL,
	[created_by] [bigint] NULL,
	[date_in] [date] NULL,
	[time_in] [time](7) NULL,
	[date_out] [date] NULL,
	[time_out] [time](7) NULL,
	[date_check_in] [date] NULL,
	[time_check_in] [time](7) NULL,
	[date_check_out] [date] NULL,
	[time_check_out] [time](7) NULL,
	[visit_status] [bigint] NULL,
	[workstation] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [smallint] NULL,
	[finish_date] [date] NULL,
	[finish_time] [time](7) NULL,
	[card_returned_date] [date] NULL,
	[reset_id] [int] NULL,
	[negate_reason] [varchar](250) NULL,
	[card_option] [varchar](25) NULL,
	[card_lost_declaration_file] [varchar](max) NULL,
	[police_report_number] [varchar](50) NULL,
	[asic_escort] [bigint] NULL,
 CONSTRAINT [PK_visit_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visit_reason]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[visit_reason](
	[id] [bigint] IDENTITY(6,1) NOT NULL,
	[reason] [varchar](max) NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [smallint] NOT NULL,
 CONSTRAINT [PK_visit_reason_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visit_status]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[visit_status](
	[id] [bigint] IDENTITY(7,1) NOT NULL,
	[name] [varchar](25) NULL,
	[created_by] [bigint] NULL,
 CONSTRAINT [PK_visit_status_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[visitor](
	[id] [bigint] IDENTITY(2604,1) NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[middle_name] [varchar](50) NULL,
	[last_name] [varchar](50) NOT NULL,
	[email] [varchar](50) NOT NULL,
	[contact_number] [varchar](20) NOT NULL,
	[date_of_birth] [date] NULL,
	[company] [bigint] NULL,
	[department] [varchar](50) NULL,
	[position] [varchar](50) NULL,
	[staff_id] [varchar](50) NULL,
	[notes] [varchar](max) NULL,
	[password] [varchar](150) NULL,
	[role] [bigint] NOT NULL,
	[visitor_type] [bigint] NULL,
	[visitor_status] [bigint] NULL,
	[vehicle] [bigint] NULL,
	[photo] [bigint] NULL,
	[created_by] [bigint] NULL,
	[is_deleted] [smallint] NOT NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[visitor_card_status] [bigint] NULL,
	[visitor_workstation] [bigint] NULL,
	[profile_type] [varchar](9) NOT NULL,
	[identification_type] [varchar](15) NULL,
	[identification_country_issued] [int] NULL,
	[identification_document_no] [varchar](50) NULL,
	[identification_document_expiry] [date] NULL,
	[identification_alternate_document_name1] [varchar](50) NULL,
	[identification_alternate_document_no1] [varchar](50) NULL,
	[identification_alternate_document_expiry1] [date] NULL,
	[identification_alternate_document_name2] [varchar](50) NULL,
	[identification_alternate_document_no2] [varchar](50) NULL,
	[identification_alternate_document_expiry2] [date] NULL,
	[contact_unit] [varchar](50) NULL,
	[contact_street_no] [varchar](50) NULL,
	[contact_street_name] [varchar](50) NULL,
	[contact_street_type] [varchar](8) NULL,
	[contact_suburb] [varchar](50) NULL,
	[contact_state] [varchar](50) NULL,
	[contact_country] [int] NULL,
	[asic_no] [varchar](50) NULL,
	[asic_expiry] [date] NULL,
	[verifiable_signature] [int] NULL,
	[contact_postcode] [varchar](10) NULL,
	[date_created] [datetime] NOT NULL,
	[escort_flag] [bit] NULL,
	[is_under_18] [tinyint] NULL,
	[under_18_detail] [varchar](255) NULL,
	[key_string] [text] NULL,
 CONSTRAINT [PK_visitor_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor_card_status]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[visitor_card_status](
	[id] [bigint] IDENTITY(8,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL,
	[profile_type] [nvarchar](9) NOT NULL,
 CONSTRAINT [PK_visitor_card_status_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[visitor_status]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[visitor_status](
	[id] [bigint] IDENTITY(4,1) NOT NULL,
	[name] [varchar](20) NULL,
 CONSTRAINT [PK_visitor_status_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[visitor_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[visitor_type](
	[id] [bigint] IDENTITY(18,1) NOT NULL,
	[name] [varchar](25) NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [int] NULL,
	[is_default_value] [int] NULL,
 CONSTRAINT [PK_visitor_type_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[workstation]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[workstation](
	[id] [bigint] IDENTITY(68,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[location] [varchar](100) NULL,
	[contact_name] [varchar](50) NULL,
	[contact_number] [int] NULL,
	[contact_email_address] [varchar](50) NULL,
	[number_of_operators] [int] NULL,
	[assign_kiosk] [smallint] NULL,
	[password] [varchar](50) NULL,
	[created_by] [bigint] NULL,
	[tenant] [bigint] NULL,
	[tenant_agent] [bigint] NULL,
	[is_deleted] [smallint] NULL,
	[timezone_id] [bigint] NOT NULL,
 CONSTRAINT [PK_workstation_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[workstation_card_type]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[workstation_card_type](
	[workstation] [bigint] NOT NULL,
	[card_type] [bigint] NOT NULL,
	[user] [bigint] NOT NULL,
 CONSTRAINT [PK_workstation_card_type_workstation] PRIMARY KEY CLUSTERED 
(
	[workstation] ASC,
	[card_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[yiisession]    Script Date: 7/20/2015 2:53:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[yiisession](
	[id] [nvarchar](255) NULL,
	[expire] [int] NULL,
	[data] [varbinary](max) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Index [card_image_generated_filename]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [card_image_generated_filename] ON [dbo].[card_generated]
(
	[card_image_generated_filename] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card_status]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [card_status] ON [dbo].[card_generated]
(
	[card_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[card_generated]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[card_generated]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[card_generated]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_id]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visitor_id] ON [dbo].[card_generated]
(
	[visitor_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[card_status]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card_type_module]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [card_type_module] ON [dbo].[card_type]
(
	[module] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[card_type]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [company_laf_preferences]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [company_laf_preferences] ON [dbo].[company]
(
	[company_laf_preferences] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by_user]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by_user] ON [dbo].[company]
(
	[created_by_user] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by_visitor]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by_visitor] ON [dbo].[company]
(
	[created_by_visitor] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [logo]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [logo] ON [dbo].[company]
(
	[logo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[company]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[company]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [helpdesk_helpdesk_group]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [helpdesk_helpdesk_group] ON [dbo].[helpdesk]
(
	[helpdesk_group_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user_id]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [user_id] ON [dbo].[password_change_request]
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[roles]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_tenant_contact_tenant1_idx]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [fk_tenant_contact_tenant1_idx] ON [dbo].[tenant_contact]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [company]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [company] ON [dbo].[user]
(
	[company] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [role]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [role] ON [dbo].[user]
(
	[role] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[user]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[user]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user_status]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [user_status] ON [dbo].[user]
(
	[user_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user_type]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [user_type] ON [dbo].[user]
(
	[user_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user_status]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user_type]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[user_workstation]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [user]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [user] ON [dbo].[user_workstation]
(
	[user] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [workstation] ON [dbo].[user_workstation]
(
	[workstation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [card] ON [dbo].[visit]
(
	[card] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [card_type]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [card_type] ON [dbo].[visit]
(
	[card_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visit]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [host]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [host] ON [dbo].[visit]
(
	[host] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [patient]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [patient] ON [dbo].[visit]
(
	[patient] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [reason]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [reason] ON [dbo].[visit]
(
	[reason] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[visit]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[visit]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visit_status]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visit_status] ON [dbo].[visit]
(
	[visit_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_status]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visitor_status] ON [dbo].[visit]
(
	[visitor_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_type]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visitor_type] ON [dbo].[visit]
(
	[visitor_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [workstation] ON [dbo].[visit]
(
	[workstation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visit_reason]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[visit_reason]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[visit_reason]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visit_status]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [company]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [company] ON [dbo].[visitor]
(
	[company] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [contact_country_fk]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [contact_country_fk] ON [dbo].[visitor]
(
	[contact_country] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visitor]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [identification_country_fk]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [identification_country_fk] ON [dbo].[visitor]
(
	[identification_country_issued] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [photo]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [photo] ON [dbo].[visitor]
(
	[photo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [role]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [role] ON [dbo].[visitor]
(
	[role] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant] ON [dbo].[visitor]
(
	[tenant] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [tenant_agent]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [tenant_agent] ON [dbo].[visitor]
(
	[tenant_agent] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [vehicle]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [vehicle] ON [dbo].[visitor]
(
	[vehicle] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_card_status]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visitor_card_status] ON [dbo].[visitor]
(
	[visitor_card_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_status]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visitor_status] ON [dbo].[visitor]
(
	[visitor_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_type]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visitor_type] ON [dbo].[visitor]
(
	[visitor_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [visitor_workstation]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [visitor_workstation] ON [dbo].[visitor]
(
	[visitor_workstation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[visitor_type]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [created_by]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [created_by] ON [dbo].[workstation]
(
	[created_by] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation_card_type_card_type]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [workstation_card_type_card_type] ON [dbo].[workstation_card_type]
(
	[card_type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [workstation_card_user]    Script Date: 7/20/2015 2:53:15 AM ******/
CREATE NONCLUSTERED INDEX [workstation_card_user] ON [dbo].[workstation_card_type]
(
	[user] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[access_tokens] ADD  DEFAULT (NULL) FOR [EXPIRY]
GO
ALTER TABLE [dbo].[access_tokens] ADD  DEFAULT (NULL) FOR [USER_TYPE]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [description]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [old_value]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [new_value]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [action]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [model]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [model_id]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [field]
GO
ALTER TABLE [dbo].[audit_trail] ADD  DEFAULT (NULL) FOR [user_id]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [card_number]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [date_printed]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [date_expiration]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [date_cancelled]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [date_returned]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [card_image_generated_filename]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [visitor_id]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [card_status]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[card_generated] ADD  DEFAULT ((0)) FOR [print_count]
GO
ALTER TABLE [dbo].[card_status] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[card_type] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[card_type] ADD  DEFAULT (NULL) FOR [max_day_validity]
GO
ALTER TABLE [dbo].[card_type] ADD  DEFAULT (NULL) FOR [max_time_validity]
GO
ALTER TABLE [dbo].[card_type] ADD  DEFAULT (NULL) FOR [max_entry_count_validity]
GO
ALTER TABLE [dbo].[card_type] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[card_type] ADD  DEFAULT (NULL) FOR [module]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [trading_name]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [logo]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [contact]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [billing_address]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [email_address]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [office_number]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [website]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [company_laf_preferences]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [created_by_user]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [created_by_visitor]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [card_count]
GO
ALTER TABLE [dbo].[company] ADD  DEFAULT (NULL) FOR [company_type]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [action_forward_bg_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [action_forward_bg_color2]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [action_forward_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [action_forward_hover_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [action_forward_hover_color2]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [action_forward_hover_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [complete_bg_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [complete_bg_color2]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [complete_hover_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [complete_hover_color2]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [complete_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [complete_hover_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [neutral_bg_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [neutral_bg_color2]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [neutral_hover_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [neutral_hover_color2]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [neutral_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [neutral_hover_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [nav_bg_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [nav_hover_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [nav_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [nav_hover_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [sidemenu_bg_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [sidemenu_hover_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [sidemenu_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [sidemenu_hover_font_color]
GO
ALTER TABLE [dbo].[company_laf_preferences] ADD  DEFAULT (NULL) FOR [css_file_path]
GO
ALTER TABLE [dbo].[company_type] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[contact_person] ADD  DEFAULT (getdate()) FOR [date_created]
GO
ALTER TABLE [dbo].[country] ADD  DEFAULT (N'') FOR [code]
GO
ALTER TABLE [dbo].[country] ADD  DEFAULT (N'') FOR [name]
GO
ALTER TABLE [dbo].[helpdesk] ADD  DEFAULT (NULL) FOR [order_by]
GO
ALTER TABLE [dbo].[helpdesk] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[helpdesk] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[helpdesk_group] ADD  DEFAULT (NULL) FOR [order_by]
GO
ALTER TABLE [dbo].[helpdesk_group] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[helpdesk_group] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[import_hosts] ADD  DEFAULT (NULL) FOR [imported_by]
GO
ALTER TABLE [dbo].[import_hosts] ADD  DEFAULT (NULL) FOR [date_imported]
GO
ALTER TABLE [dbo].[import_hosts] ADD  DEFAULT (NULL) FOR [role]
GO
ALTER TABLE [dbo].[import_hosts] ADD  DEFAULT (NULL) FOR [position]
GO
ALTER TABLE [dbo].[import_hosts] ADD  DEFAULT (NULL) FOR [date_of_birth]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [card_code]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [check_in_date]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [check_out_date]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [imported_by]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [import_date]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [check_in_time]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [check_out_time]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [position]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [date_printed]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [date_expiration]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [vehicle]
GO
ALTER TABLE [dbo].[import_visitor] ADD  DEFAULT (NULL) FOR [contact_number]
GO
ALTER TABLE [dbo].[module] ADD  DEFAULT (NULL) FOR [about]
GO
ALTER TABLE [dbo].[module] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[notification] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[notification] ADD  DEFAULT (NULL) FOR [date_created]
GO
ALTER TABLE [dbo].[notification] ADD  DEFAULT (NULL) FOR [role_id]
GO
ALTER TABLE [dbo].[notification] ADD  DEFAULT (NULL) FOR [notification_type]
GO
ALTER TABLE [dbo].[password_change_request] ADD  DEFAULT ((0)) FOR [user_id]
GO
ALTER TABLE [dbo].[password_change_request] ADD  DEFAULT (N'') FOR [hash]
GO
ALTER TABLE [dbo].[password_change_request] ADD  DEFAULT (getdate()) FOR [created_at]
GO
ALTER TABLE [dbo].[password_change_request] ADD  DEFAULT (N'NO') FOR [is_used]
GO
ALTER TABLE [dbo].[patient] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[reasons] ADD  DEFAULT (getdate()) FOR [date_created]
GO
ALTER TABLE [dbo].[reset_history] ADD  DEFAULT (NULL) FOR [lodgement_date]
GO
ALTER TABLE [dbo].[roles] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[tbl_migration] ADD  DEFAULT (NULL) FOR [apply_time]
GO
ALTER TABLE [dbo].[tenant] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [date_of_birth]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [company]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [department]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [position]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [staff_id]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [password]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT ((1)) FOR [user_status]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [asic_no]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [asic_expiry]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [is_required_induction]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [is_completed_induction]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT (NULL) FOR [induction_expiry]
GO
ALTER TABLE [dbo].[user_notification] ADD  DEFAULT (NULL) FOR [user_id]
GO
ALTER TABLE [dbo].[user_notification] ADD  DEFAULT (NULL) FOR [notification_id]
GO
ALTER TABLE [dbo].[user_notification] ADD  DEFAULT (NULL) FOR [has_read]
GO
ALTER TABLE [dbo].[user_notification] ADD  DEFAULT (NULL) FOR [date_read]
GO
ALTER TABLE [dbo].[user_status] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[user_type] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[user_workstation] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[user_workstation] ADD  DEFAULT ((0)) FOR [is_primary]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [visitor]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [card_type]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [card]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [visitor_type]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [reason]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT ((1)) FOR [visitor_status]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [host]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [patient]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [date_in]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [time_in]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [date_out]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [time_out]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [date_check_in]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [time_check_in]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [date_check_out]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [time_check_out]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [visit_status]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [workstation]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [finish_date]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [finish_time]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [card_returned_date]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [reset_id]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (NULL) FOR [negate_reason]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (N'Returned') FOR [card_option]
GO
ALTER TABLE [dbo].[visit] ADD  DEFAULT (N'') FOR [police_report_number]
GO
ALTER TABLE [dbo].[visit_reason] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[visit_reason] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[visit_reason] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[visit_reason] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[visit_status] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[visit_status] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [middle_name]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [date_of_birth]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [company]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [department]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [position]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [staff_id]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [password]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT ((10)) FOR [role]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [visitor_type]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT ((1)) FOR [visitor_status]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [vehicle]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [photo]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [visitor_card_status]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [visitor_workstation]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (N'CORPORATE') FOR [profile_type]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_type]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_country_issued]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_document_no]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_document_expiry]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_alternate_document_name1]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_alternate_document_no1]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_alternate_document_expiry1]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_alternate_document_name2]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_alternate_document_no2]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [identification_alternate_document_expiry2]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_unit]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_street_no]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_street_name]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_street_type]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_suburb]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_state]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_country]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [asic_no]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [asic_expiry]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT ((0)) FOR [verifiable_signature]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (NULL) FOR [contact_postcode]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT (getdate()) FOR [date_created]
GO
ALTER TABLE [dbo].[visitor] ADD  DEFAULT ((0)) FOR [is_under_18]
GO
ALTER TABLE [dbo].[visitor_card_status] ADD  DEFAULT (N'CORPORATE') FOR [profile_type]
GO
ALTER TABLE [dbo].[visitor_status] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[visitor_type] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[visitor_type] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[visitor_type] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[visitor_type] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[visitor_type] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[visitor_type] ADD  DEFAULT ((0)) FOR [is_default_value]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [location]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [contact_name]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [contact_number]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [contact_email_address]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [number_of_operators]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT ((0)) FOR [assign_kiosk]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [password]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [tenant]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT (NULL) FOR [tenant_agent]
GO
ALTER TABLE [dbo].[workstation] ADD  DEFAULT ((0)) FOR [is_deleted]
GO
ALTER TABLE [dbo].[yiisession] ADD  DEFAULT (NULL) FOR [id]
GO
ALTER TABLE [dbo].[yiisession] ADD  DEFAULT (NULL) FOR [expire]
GO
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_1] FOREIGN KEY([card_image_generated_filename])
REFERENCES [dbo].[photo] ([id])
GO
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_1]
GO
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_2] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_2]
GO
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_3] FOREIGN KEY([tenant])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_3]
GO
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_5] FOREIGN KEY([visitor_id])
REFERENCES [dbo].[visitor] ([id])
GO
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_5]
GO
ALTER TABLE [dbo].[card_generated]  WITH NOCHECK ADD  CONSTRAINT [card_generated$card_generated_ibfk_6] FOREIGN KEY([card_status])
REFERENCES [dbo].[card_status] ([id])
GO
ALTER TABLE [dbo].[card_generated] CHECK CONSTRAINT [card_generated$card_generated_ibfk_6]
GO
ALTER TABLE [dbo].[card_status]  WITH NOCHECK ADD  CONSTRAINT [card_status$card_status_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[card_status] CHECK CONSTRAINT [card_status$card_status_ibfk_1]
GO
ALTER TABLE [dbo].[card_type]  WITH NOCHECK ADD  CONSTRAINT [card_type$card_type_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[card_type] CHECK CONSTRAINT [card_type$card_type_ibfk_1]
GO
ALTER TABLE [dbo].[card_type]  WITH NOCHECK ADD  CONSTRAINT [card_type$card_type_module] FOREIGN KEY([module])
REFERENCES [dbo].[module] ([id])
GO
ALTER TABLE [dbo].[card_type] CHECK CONSTRAINT [card_type$card_type_module]
GO
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_1] FOREIGN KEY([created_by_user])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_1]
GO
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_2] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_2]
GO
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_4] FOREIGN KEY([company_laf_preferences])
REFERENCES [dbo].[company_laf_preferences] ([id])
GO
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_4]
GO
ALTER TABLE [dbo].[company]  WITH NOCHECK ADD  CONSTRAINT [company$company_ibfk_5] FOREIGN KEY([logo])
REFERENCES [dbo].[photo] ([id])
GO
ALTER TABLE [dbo].[company] CHECK CONSTRAINT [company$company_ibfk_5]
GO
ALTER TABLE [dbo].[files]  WITH CHECK ADD  CONSTRAINT [files_folders_fk] FOREIGN KEY([folder_id])
REFERENCES [dbo].[folders] ([id])
GO
ALTER TABLE [dbo].[files] CHECK CONSTRAINT [files_folders_fk]
GO
ALTER TABLE [dbo].[files]  WITH CHECK ADD  CONSTRAINT [files_user_fk] FOREIGN KEY([user_id])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[files] CHECK CONSTRAINT [files_user_fk]
GO
ALTER TABLE [dbo].[folders]  WITH CHECK ADD  CONSTRAINT [folders_user_fk] FOREIGN KEY([user_id])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[folders] CHECK CONSTRAINT [folders_user_fk]
GO
ALTER TABLE [dbo].[helpdesk]  WITH NOCHECK ADD  CONSTRAINT [helpdesk$helpdesk_helpdesk_group] FOREIGN KEY([helpdesk_group_id])
REFERENCES [dbo].[helpdesk_group] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[helpdesk] CHECK CONSTRAINT [helpdesk$helpdesk_helpdesk_group]
GO
ALTER TABLE [dbo].[password_change_request]  WITH NOCHECK ADD  CONSTRAINT [password_change_request$user_password_change_request_user_id] FOREIGN KEY([user_id])
REFERENCES [dbo].[user] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[password_change_request] CHECK CONSTRAINT [password_change_request$user_password_change_request_user_id]
GO
ALTER TABLE [dbo].[roles]  WITH NOCHECK ADD  CONSTRAINT [roles$roles_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[roles] CHECK CONSTRAINT [roles$roles_ibfk_1]
GO
ALTER TABLE [dbo].[tenant]  WITH NOCHECK ADD  CONSTRAINT [tenant$fk_tenant_company1] FOREIGN KEY([id])
REFERENCES [dbo].[company] ([id])
GO
ALTER TABLE [dbo].[tenant] CHECK CONSTRAINT [tenant$fk_tenant_company1]
GO
ALTER TABLE [dbo].[tenant_contact]  WITH NOCHECK ADD  CONSTRAINT [tenant_contact$fk_tenant_contact_tenant1] FOREIGN KEY([tenant])
REFERENCES [dbo].[tenant] ([id])
GO
ALTER TABLE [dbo].[tenant_contact] CHECK CONSTRAINT [tenant_contact$fk_tenant_contact_tenant1]
GO
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_1] FOREIGN KEY([role])
REFERENCES [dbo].[roles] ([id])
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_1]
GO
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_2] FOREIGN KEY([user_type])
REFERENCES [dbo].[user_type] ([id])
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_2]
GO
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_3] FOREIGN KEY([user_status])
REFERENCES [dbo].[user_status] ([id])
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_3]
GO
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_4] FOREIGN KEY([company])
REFERENCES [dbo].[company] ([id])
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_4]
GO
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_5] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_5]
GO
ALTER TABLE [dbo].[user]  WITH NOCHECK ADD  CONSTRAINT [user$user_ibfk_7] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [user$user_ibfk_7]
GO
ALTER TABLE [dbo].[user_status]  WITH NOCHECK ADD  CONSTRAINT [user_status$user_status_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[user_status] CHECK CONSTRAINT [user_status$user_status_ibfk_1]
GO
ALTER TABLE [dbo].[user_type]  WITH NOCHECK ADD  CONSTRAINT [user_type$user_type_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[user_type] CHECK CONSTRAINT [user_type$user_type_ibfk_1]
GO
ALTER TABLE [dbo].[user_workstation]  WITH NOCHECK ADD  CONSTRAINT [user_workstation$user_workstation_ibfk_1] FOREIGN KEY([workstation])
REFERENCES [dbo].[workstation] ([id])
GO
ALTER TABLE [dbo].[user_workstation] CHECK CONSTRAINT [user_workstation$user_workstation_ibfk_1]
GO
ALTER TABLE [dbo].[user_workstation]  WITH NOCHECK ADD  CONSTRAINT [user_workstation$user_workstation_ibfk_2] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[user_workstation] CHECK CONSTRAINT [user_workstation$user_workstation_ibfk_2]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_1] FOREIGN KEY([card])
REFERENCES [dbo].[card_generated] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_1]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_10] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_10]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_11] FOREIGN KEY([card_type])
REFERENCES [dbo].[card_type] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_11]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_12] FOREIGN KEY([visit_status])
REFERENCES [dbo].[visit_status] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_12]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_13] FOREIGN KEY([workstation])
REFERENCES [dbo].[workstation] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_13]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_3] FOREIGN KEY([reason])
REFERENCES [dbo].[visit_reason] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_3]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_4] FOREIGN KEY([visitor_type])
REFERENCES [dbo].[visitor_type] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_4]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_5] FOREIGN KEY([visitor_status])
REFERENCES [dbo].[visitor_status] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_5]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_7] FOREIGN KEY([patient])
REFERENCES [dbo].[patient] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_7]
GO
ALTER TABLE [dbo].[visit]  WITH NOCHECK ADD  CONSTRAINT [visit$visit_ibfk_8] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visit] CHECK CONSTRAINT [visit$visit_ibfk_8]
GO
ALTER TABLE [dbo].[visit_reason]  WITH NOCHECK ADD  CONSTRAINT [visit_reason$visit_reason_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visit_reason] CHECK CONSTRAINT [visit_reason$visit_reason_ibfk_1]
GO
ALTER TABLE [dbo].[visit_reason]  WITH NOCHECK ADD  CONSTRAINT [visit_reason$visit_reason_ibfk_3] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visit_reason] CHECK CONSTRAINT [visit_reason$visit_reason_ibfk_3]
GO
ALTER TABLE [dbo].[visit_status]  WITH NOCHECK ADD  CONSTRAINT [visit_status$visit_status_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visit_status] CHECK CONSTRAINT [visit_status$visit_status_ibfk_1]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$contact_country_fk] FOREIGN KEY([contact_country])
REFERENCES [dbo].[country] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$contact_country_fk]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$identification_country_fk] FOREIGN KEY([identification_country_issued])
REFERENCES [dbo].[country] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$identification_country_fk]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_card_status_fk] FOREIGN KEY([visitor_card_status])
REFERENCES [dbo].[visitor_card_status] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_card_status_fk]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_1] FOREIGN KEY([visitor_type])
REFERENCES [dbo].[visitor_type] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_1]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_2] FOREIGN KEY([visitor_status])
REFERENCES [dbo].[visitor_status] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_2]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_3] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_3]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_5] FOREIGN KEY([tenant_agent])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_5]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_6] FOREIGN KEY([role])
REFERENCES [dbo].[roles] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_6]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_7] FOREIGN KEY([company])
REFERENCES [dbo].[company] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_7]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_8] FOREIGN KEY([vehicle])
REFERENCES [dbo].[vehicle] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_8]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_ibfk_9] FOREIGN KEY([photo])
REFERENCES [dbo].[photo] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_ibfk_9]
GO
ALTER TABLE [dbo].[visitor]  WITH NOCHECK ADD  CONSTRAINT [visitor$visitor_workstation_fk] FOREIGN KEY([visitor_workstation])
REFERENCES [dbo].[workstation] ([id])
GO
ALTER TABLE [dbo].[visitor] CHECK CONSTRAINT [visitor$visitor_workstation_fk]
GO
ALTER TABLE [dbo].[visitor_type]  WITH NOCHECK ADD  CONSTRAINT [visitor_type$visitor_type_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[visitor_type] CHECK CONSTRAINT [visitor_type$visitor_type_ibfk_1]
GO
ALTER TABLE [dbo].[workstation]  WITH NOCHECK ADD  CONSTRAINT [workstation$workstation_ibfk_1] FOREIGN KEY([created_by])
REFERENCES [dbo].[user] ([id])
GO
ALTER TABLE [dbo].[workstation] CHECK CONSTRAINT [workstation$workstation_ibfk_1]
GO
ALTER TABLE [dbo].[workstation_card_type]  WITH NOCHECK ADD  CONSTRAINT [workstation_card_type$workstation_card_type_card_type] FOREIGN KEY([card_type])
REFERENCES [dbo].[card_type] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[workstation_card_type] CHECK CONSTRAINT [workstation_card_type$workstation_card_type_card_type]
GO
ALTER TABLE [dbo].[workstation_card_type]  WITH NOCHECK ADD  CONSTRAINT [workstation_card_type$workstation_card_type_workstation] FOREIGN KEY([workstation])
REFERENCES [dbo].[workstation] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[workstation_card_type] CHECK CONSTRAINT [workstation_card_type$workstation_card_type_workstation]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.password_change_request' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'enum2str$password_change_request$is_used'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'enum2str$visitor$contact_street_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'enum2str$visitor$identification_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'enum2str$visitor$profile_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_card_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'enum2str$visitor_card_status$profile_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.password_change_request' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'norm_enum$password_change_request$is_used'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'norm_enum$visitor$contact_street_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'norm_enum$visitor$identification_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'norm_enum$visitor$profile_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_card_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'norm_enum$visitor_card_status$profile_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.password_change_request' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'str2enum$password_change_request$is_used'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'str2enum$visitor$contact_street_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'str2enum$visitor$identification_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'str2enum$visitor$profile_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_card_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'FUNCTION',@level1name=N'str2enum$visitor_card_status$profile_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.access_tokens' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'access_tokens'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.audit_trail' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'audit_trail'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.card_generated' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_generated'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.card_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_status'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.card_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'card_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.cardstatus_convert' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'cardstatus_convert'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.company' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.company_laf_preferences' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company_laf_preferences'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.company_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'company_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.country' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'country'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.cvms_kiosk' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'cvms_kiosk'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.helpdesk' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'helpdesk'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.helpdesk_group' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'helpdesk_group'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.import_hosts' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'import_hosts'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.import_visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'import_visitor'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.license_details' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'license_details'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.module' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'module'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.notification' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'notification'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.password_change_request' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'password_change_request'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.patient' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'patient'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.photo' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'photo'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.reasons' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'reasons'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.reset_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'reset_history'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.roles' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'roles'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.tbl_migration' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tbl_migration'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.tenant' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tenant'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.tenant_contact' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tenant_contact'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.timezone' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'timezone'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.`user`' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_notification' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_notification'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_status'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.user_workstation' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_workstation'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.vehicle' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'vehicle'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visit' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visit_reason' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit_reason'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visit_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visit_status'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_card_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_card_status'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_status'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.visitor_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'visitor_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.workstation' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'workstation'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.workstation_card_type' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'workstation_card_type'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'vms.yiisession' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'yiisession'
GO
USE [master]
GO
ALTER DATABASE [vms] SET  READ_WRITE 
GO
