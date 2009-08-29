<?xml version="1.0" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text"/>

<xsl:template match="/sql">

	<!-- tables -->
	<xsl:for-each select="table">

		<!-- if there is a comment, let's display it on its own line starting with # -->
		<xsl:if test="comment">
			<xsl:text># </xsl:text>
			<xsl:value-of select="comment" />
			<xsl:text>
</xsl:text>
		</xsl:if>

		<!-- table name -->
		<xsl:value-of select="@name" />
		<xsl:text>:
</xsl:text>

		<!-- get table propertie "rows" -->
		<xsl:for-each select="row">
			<xsl:if test="default">
				<xsl:choose>
					<xsl:when test="datatype='tableName'">
						<xsl:text>  tableName: </xsl:text>
						<xsl:value-of select="default"/>
						<xsl:text> ]
</xsl:text>
					</xsl:when>
					<xsl:when test="datatype='tableClassName'">
						<xsl:text>  className: </xsl:text>
						<xsl:value-of select="default"/>
						<xsl:text> ]
</xsl:text>
					</xsl:when>
					<xsl:when test="datatype='tableOptions'">
						<xsl:text>  options: [ </xsl:text>
						<xsl:value-of select="default"/>
						<xsl:text> ]
</xsl:text>
					</xsl:when>
					<xsl:when test="datatype='tableActAs'">
						<xsl:text>  actAs: [ </xsl:text>
						<xsl:value-of select="default"/>
						<xsl:text> ]
</xsl:text>
					</xsl:when>
				</xsl:choose>
			</xsl:if>
		</xsl:for-each>

		<xsl:text>  columns:
</xsl:text>
			<xsl:for-each select="row">

				<!-- skip table propertie "rows" -->
				<xsl:if test="not(datatype='tableActAs') and not(datatype='tableName') and not(datatype='tableClassName') and not(datatype='tableOptions')">

					<!-- if there is a comment, let's display it on its own line starting with # -->
					<xsl:if test="comment">
						<xsl:text>    # </xsl:text>
						<xsl:value-of select="comment" />
						<xsl:text>
</xsl:text>
					</xsl:if>

					<!-- first the name -->
					<xsl:text>    </xsl:text>
					<xsl:value-of select="@name" />
					<xsl:text>: { type: </xsl:text>

					<!-- then the datatype -->
					<xsl:choose>
						<xsl:when test="contains(datatype,'decimal')">
							<xsl:value-of select="substring-before(datatype,',')"/>
							<xsl:text>), scale: </xsl:text>
							<xsl:value-of select="substring-before(substring-after(datatype,','),')')"/>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="datatype" />
						</xsl:otherwise>
					</xsl:choose>

					<!-- is it a primary key? -->
					<xsl:variable name="rowname" select="@name" />
					<xsl:for-each select="../key">
						<xsl:if test="@type = 'PRIMARY'">
							<xsl:for-each select="part">
								<xsl:if test=".=$rowname">
									<xsl:text>, primary: true</xsl:text>
								</xsl:if>
							</xsl:for-each>
						</xsl:if>
					</xsl:for-each>

					<!-- can it be null? -->
					<xsl:if test="@null = 0">
						<xsl:text>, notnull: true</xsl:text>
					</xsl:if>

					<!-- is an autoincrement? -->
					<xsl:if test="@autoincrement = 1">
						<xsl:text>, autoincrement: true</xsl:text>
					</xsl:if>

					<!-- default value. for enum list of values, the first will be default -->
					<xsl:if test="default">
						<xsl:choose>
							<xsl:when test="contains(datatype,'enum')">
								<xsl:text>, values: [ </xsl:text>
								<xsl:value-of select="default" />
								<xsl:text> ]</xsl:text>
								<xsl:text>, default: </xsl:text>
								<xsl:choose>
									<xsl:when test="contains(default,',')">
										<xsl:value-of select="substring-before(default,',')"/>
									</xsl:when>
									<xsl:otherwise>
										<xsl:value-of select="default" />
									</xsl:otherwise>
								</xsl:choose>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text>, values: [ </xsl:text>
								<xsl:value-of select="default" />
								<xsl:text> ]</xsl:text>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:if>


					<!-- jump to next field -->
					<xsl:text> }
</xsl:text>

				<!-- end if to skip table properties -->
				</xsl:if>



			<!-- end loop on rows -->
			</xsl:for-each>

<!-- find indexes -->
<xsl:if test="count(key[@type='INDEX' or @type='UNIQUE'])>0">
						<xsl:text>  indexes:
</xsl:text>
	<xsl:for-each select="key">
		<xsl:if test="@type = 'INDEX' or @type = 'UNIQUE'">
			<xsl:text>    </xsl:text>
			<xsl:value-of select="@name" />
			<xsl:text>:
      fields: [ </xsl:text>
				<xsl:for-each select="part">
					<xsl:value-of select="." />
					<xsl:if test="not (position() = last())">
						<xsl:text>, </xsl:text>
					</xsl:if>
				</xsl:for-each>
				<xsl:text> ]
</xsl:text>
		</xsl:if>
		<xsl:if test=" @type = 'UNIQUE'">
			<xsl:text>      unique: true
</xsl:text>
		</xsl:if>

	<!-- end loop to find indexes -->
	</xsl:for-each>
</xsl:if>


<!-- find relationships -->
<xsl:if test="count(*/relation)>0">
						<xsl:text>  relations:
</xsl:text>
	<xsl:for-each select="*/relation">
			<xsl:text>    </xsl:text>
			<xsl:value-of select="@table" />
			<xsl:text>:
      local: </xsl:text>
			<xsl:value-of select="../@name" />
			<xsl:text>
      foreign: </xsl:text>
			<xsl:value-of select="@row" />
			<xsl:text>
</xsl:text>
	<!-- end loop to find relationships-->
	</xsl:for-each>
</xsl:if>

<!-- end loop on table -->
			<xsl:text>
</xsl:text>
</xsl:for-each>


</xsl:template>
</xsl:stylesheet>
